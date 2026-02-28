<?php

namespace App\Http\Controllers\Backend\Transaction_Management;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use App\Models\Purchase;
use App\Models\SupplierPayment;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class SupplierPaymentController extends Controller
{
    public function index()
    {
        $payments = SupplierPayment::with(['supplier', 'purchase'])
            ->latest()
            ->get();

        return view(
            'backend.transaction_management.supplier_payment.index',
            compact('payments')
        );
    }

    public function create()
    {
        $purchases = Purchase::with('supplier')->get();

        return view(
            'backend.transaction_management.supplier_payment.create',
            compact('purchases')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'purchase_id'  => 'required|exists:purchases,id',
            'amount'       => 'required|numeric|min:1',
            'payment_date' => 'required|date',
        ]);

        DB::transaction(function () use ($request) {

            $purchase = Purchase::with('payments', 'supplier')
                ->findOrFail($request->purchase_id);

            $totalPaid = $purchase->payments()->sum('amount');
            $dueAmount = $purchase->total_amount - $totalPaid;

            // 🚫 Prevent overpayment
            if ($request->amount > $dueAmount) {
                throw ValidationException::withMessages([
                    'amount' => 'Payment exceeds due amount. Current due: ' . $dueAmount,
                ]);
            }

            // 🔥 Create Supplier Payment
            $supplierPayment = SupplierPayment::create([
                'payment_no'     => 'SP-' . now()->format('YmdHis'),
                'supplier_id'    => $purchase->supplier_id,
                'purchase_id'    => $purchase->id,
                'amount'         => $request->amount,
                'payment_date'   => $request->payment_date,
                'payment_method' => $request->payment_method,
                'note'           => $request->note,
            ]);

            // 🔥 Update Purchase Status
            $newTotalPaid = $purchase->payments()->sum('amount');
            $newDue = $purchase->total_amount - $newTotalPaid;

            if ($newDue <= 0) {
                $purchase->update(['status' => 'paid']);
            } elseif ($newTotalPaid > 0) {
                $purchase->update(['status' => 'partial']);
            }

            // 🔥 Activity Log
            activity()
                ->causedBy(auth()->user())
                ->performedOn($supplierPayment)
                ->withProperties([
                    'payment_no'     => $supplierPayment->payment_no,
                    'supplier_name'  => $purchase->supplier->name ?? null,
                    'purchase_ref'   => $purchase->reference_no ?? $purchase->id,
                    'paid_amount'    => $request->amount,
                    'previous_due'   => $dueAmount,
                    'remaining_due'  => $newDue,
                    'payment_method' => $request->payment_method,
                ])
                ->log('Supplier Payment Created');
        });

        return redirect()
            ->route('supplier_payments.index')
            ->with('success', 'Supplier payment created successfully.');
    }

    public function show(SupplierPayment $supplierPayment)
    {
        $supplierPayment->load(['supplier', 'purchase']);

        return view(
            'backend.transaction_management.supplier_payment.show',
            compact('supplierPayment')
        );
    }

    public function edit(SupplierPayment $supplierPayment)
    {
        $purchases = Purchase::with('supplier', 'payments')->get();

        return view(
            'backend.transaction_management.supplier_payment.edit',
            compact('supplierPayment', 'purchases')
        );
    }

    public function update(Request $request, SupplierPayment $supplierPayment)
    {
        $request->validate([
            'purchase_id'  => 'required|exists:purchases,id',
            'amount'       => 'required|numeric|min:1',
            'payment_date' => 'required|date',
        ]);

        DB::transaction(function () use ($request, $supplierPayment) {

            $purchase = Purchase::with('payments')->findOrFail($request->purchase_id);

            // Calculate due excluding current payment
            $totalPaidExcludingCurrent = $purchase->payments()
                ->where('id', '!=', $supplierPayment->id)
                ->sum('amount');

            $dueAmount = $purchase->total_amount - $totalPaidExcludingCurrent;

            if ($request->amount > $dueAmount) {
                throw ValidationException::withMessages([
                    'amount' => 'Payment exceeds due amount. Current due: ' . $dueAmount,
                ]);
            }

            $supplierPayment->update([
                'supplier_id'    => $purchase->supplier_id,
                'purchase_id'    => $purchase->id,
                'amount'         => $request->amount,
                'payment_date'   => $request->payment_date,
                'payment_method' => $request->payment_method,
                'note'           => $request->note,
            ]);

            // 🔥 Recalculate status
            $newTotalPaid = $purchase->payments()->sum('amount');
            $newDue = $purchase->total_amount - $newTotalPaid;

            if ($newDue <= 0) {
                $purchase->update(['status' => 'paid']);
            } elseif ($newTotalPaid > 0) {
                $purchase->update(['status' => 'partial']);
            } else {
                $purchase->update(['status' => 'due']);
            }
        });

        return redirect()
            ->route('supplier_payments.index')
            ->with('success', 'Supplier payment updated successfully.');
    }

    public function destroy(SupplierPayment $supplierPayment)
    {
        DB::transaction(function () use ($supplierPayment) {

            $purchase = $supplierPayment->purchase;

            $supplierPayment->delete();

            // 🔥 Recalculate status after delete
            $totalPaid = $purchase->payments()->sum('amount');
            $due = $purchase->total_amount - $totalPaid;

            if ($due <= 0) {
                $purchase->update(['status' => 'paid']);
            } elseif ($totalPaid > 0) {
                $purchase->update(['status' => 'partial']);
            } else {
                $purchase->update(['status' => 'due']);
            }
        });

        return redirect()
            ->route('supplier_payments.index')
            ->with('success', 'Supplier payment deleted successfully.');
    }
}
