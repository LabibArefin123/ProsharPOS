<?php

namespace App\Http\Controllers\Backend\Transaction_Management;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use App\Models\SupplierPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupplierPaymentController extends Controller
{
    public function index()
    {
        $payments = SupplierPayment::with(['supplier'])
            ->latest()
            ->get();

        return view('backend.transaction_management.supplier_payment.index', compact('payments'));
    }

    public function create()
    {
        $suppliers = Supplier::all();
        return view('backend.transaction_management.supplier_payment.create', compact('suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_id'  => 'required|exists:suppliers,id',
            'amount'       => 'required|numeric|min:1',
            'payment_date' => 'required|date',
        ]);

        DB::transaction(function () use ($request) {

            SupplierPayment::create([
                'payment_no'    => 'SP-' . now()->format('YmdHis'),
                'supplier_id'   => $request->supplier_id,
                'amount'        => $request->amount,
                'payment_date'  => $request->payment_date,
                'payment_method' => $request->payment_method,
                'note'          => $request->note,
                'created_by'    => auth()->id(),
            ]);
        });

        return redirect()
            ->route('supplier_payments.index')
            ->with('success', 'Supplier payment created successfully.');
    }

    public function show(SupplierPayment $supplierPayment)
    {
        return view('backend.transaction_management.supplier_payment.show', compact('supplierPayment'));
    }

    public function edit(SupplierPayment $supplierPayment)
    {
        $suppliers = Supplier::all();

        return view(
            'backend.transaction_management.supplier_payment.edit',
            compact('supplierPayment', 'suppliers')
        );
    }

    public function update(Request $request, SupplierPayment $supplierPayment)
    {
        $request->validate([
            'supplier_id'  => 'required|exists:suppliers,id',
            'amount'       => 'required|numeric|min:1',
            'payment_date' => 'required|date',
        ]);

        $supplierPayment->update([
            'supplier_id'    => $request->supplier_id,
            'amount'         => $request->amount,
            'payment_date'   => $request->payment_date,
            'payment_method' => $request->payment_method,
            'note'           => $request->note,
        ]);

        return redirect()
            ->route('supplier_payments.index')
            ->with('success', 'Supplier payment updated successfully.');
    }

    public function destroy(SupplierPayment $supplierPayment)
    {
        $supplierPayment->delete();

        return redirect()
            ->route('supplier_payments.index')
            ->with('success', 'Supplier payment deleted successfully.');
    }
}