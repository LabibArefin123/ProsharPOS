<?php

namespace App\Http\Controllers\Backend\Transaction_Management;

use App\Http\Controllers\Controller;
use App\Models\BankBalance;
use App\Models\BankDeposit;
use App\Models\BankWithdraw;
use App\Models\SalesReturn;
use App\Models\Payment;
use App\Models\SupplierPayment;
use App\Models\Purchase;
use App\Models\PurchaseReturn;
use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Activitylog\Models\Activity;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['invoice', 'paidBy'])->orderBy('id', 'desc')->get();
        return view('backend.transaction_management.payment.index', compact('payments'));
    }

    public function create()
    {
        $invoices = Invoice::where('status', 0)->get(); // pending invoices
        $users = User::all();
        return view('backend.transaction_management.payment.create', compact('invoices', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'payment_name' => 'required|string',
            'invoice_id'   => 'required|exists:invoices,id',
            'paid_amount'  => 'required|numeric|min:0',
            'due_amount'   => 'nullable|numeric|min:0',
            'paid_by'      => 'required|exists:users,id',
            'payment_type' => 'required|string',
        ]);

        $invoice = Invoice::findOrFail($request->invoice_id);

        // Add to previous paid amount (IMPORTANT)
        $newPaidAmount = $invoice->paid_amount + $request->paid_amount;

        // Create payment
        $payment = Payment::create([
            'payment_id'   => rand(100000, 999999),
            'payment_name' => $request->payment_name,
            'invoice_id'   => $request->invoice_id,
            'paid_amount'  => $request->paid_amount,
            'due_amount'   => $request->due_amount ?? 0,
            'paid_by'      => $request->paid_by,
            'payment_type' => $request->payment_type,
        ]);

        // Update invoice
        $invoice->paid_amount = $newPaidAmount;
        $invoice->paid_by     = $request->paid_by;

        if ($newPaidAmount >= $invoice->total) {
            $invoice->status = 1; // Fully Paid
        } else {
            $invoice->status = 0; // Partial
        }

        $invoice->save();

        // 🔥 Activity Log
        activity()
            ->causedBy(auth()->user())
            ->performedOn($payment)
            ->withProperties([
                'invoice_id'  => $invoice->invoice_id,
                'paid_amount' => $request->paid_amount,
                'payment_type' => $request->payment_type,
            ])
            ->log('Payment Created');

        return redirect()->route('payments.index')
            ->with('success', 'Payment recorded successfully');
    }

    public function show(Payment $payment)
    {
        return view('backend.transaction_management.payment.show', compact('payment'));
    }

    public function history()
    {
        // Deposits
        $deposits = BankDeposit::with(['bankBalance.user', 'user'])
            ->get()
            ->map(function ($d) {
                return (object)[
                    'type'        => 'deposit',
                    'date'        => $d->deposit_date,
                    'created_at'  => $d->created_at,
                    'amount'      => (float) $d->amount,
                    'currency'    => 'BDT',
                    'description' => $d->reference_no,
                    'user'        => $d->user,
                    'source'      => $d,
                ];
            });

        // Withdraws
        $withdraws = BankWithdraw::with(['bankBalance.user', 'user'])
            ->get()
            ->map(function ($w) {
                return (object)[
                    'type'        => 'withdraw',
                    'date'        => $w->withdraw_date,
                    'created_at'  => $w->created_at,
                    'amount'      => (float) $w->amount,
                    'currency'    => 'BDT',
                    'description' => $w->reference_no,
                    'user'        => $w->user,
                    'source'      => $w,
                ];
            });

        // Customer Payments
        $payments = Payment::with(['invoice.customer', 'paidBy'])
            ->get()
            ->map(function ($p) {
                return (object)[
                    'type'        => 'payment',
                    'date'        => $p->created_at,
                    'created_at'  => $p->created_at,
                    'amount'      => (float) $p->paid_amount,
                    'currency'    => 'BDT',
                    'description' => $p->invoice->invoice_id ?? 'Payment',
                    'user'        => $p->paidBy,
                    'source'      => $p,
                ];
            });

        // Supplier Payments
        $supplierPayments = SupplierPayment::with(['supplier', 'purchase'])
            ->get()
            ->map(function ($sp) {
                return (object)[
                    'type'        => 'supplier_payment',
                    'date'        => $sp->payment_date,
                    'created_at'  => $sp->created_at,
                    'amount'      => (float) $sp->amount,
                    'currency'    => 'BDT',
                    'description' => $sp->purchase->reference_no ?? 'Supplier Payment',
                    'user'        => $sp->supplier,
                    'source'      => $sp,
                ];
            });

        // Purchases
        $purchases = Purchase::with('supplier')
            ->get()
            ->map(function ($pu) {
                return (object)[
                    'type'        => 'purchase',
                    'date'        => $pu->created_at,
                    'created_at'  => $pu->created_at,
                    'amount'      => (float) $pu->total_amount,
                    'currency'    => 'BDT',
                    'description' => $pu->reference_no ?? 'Purchase',
                    'user'        => $pu->supplier,
                    'source'      => $pu,
                ];
            });

        // Purchase Returns
        $returns = PurchaseReturn::with('supplier')
            ->get()
            ->map(function ($r) {
                return (object)[
                    'type'        => 'purchase_return',
                    'date'        => $r->return_date,
                    'created_at'  => $r->created_at,
                    'amount'      => (float) $r->total_amount,
                    'currency'    => 'BDT',
                    'description' => $r->reference_no ?? 'Purchase Return',
                    'user'        => $r->supplier,
                    'source'      => $r,
                ];
            });

        // Merge everything
        $transactions = collect()
            ->merge($deposits)
            ->merge($withdraws)
            ->merge($payments)
            ->merge($supplierPayments) 
            ->merge($purchases)
            ->merge($returns)
            ->sortByDesc('created_at')
            ->values();

        // Start from latest bank balance
        $latestBank = BankBalance::latest()->first();
        $runningBalance = $latestBank?->balance ?? 0;

        // Add running balance to each transaction (for box display)
        $transactions = $transactions->map(function ($t) use (&$runningBalance) {

            $amount = abs($t->amount);

            // Determine running balance
            if (in_array($t->type, ['withdraw', 'purchase', 'supplier_payment', 'payment'])) {
                $newBalance = $runningBalance - $amount;
            } else { // deposit, purchase_return
                $newBalance = $runningBalance + $amount;
            }

            $t->old_balance = $runningBalance;
            $t->new_balance = $newBalance;

            // Update running balance for next iteration
            $runningBalance = $newBalance;

            return $t;
        });

        // Paginate manually for boxes (5 per page)
        $page = request()->get('page', 1);
        $perPage = 5;
        $transactionsPaginated = $transactions->slice(($page - 1) * $perPage, $perPage)
            ->values();
        $totalPages = ceil($transactions->count() / $perPage);

        return view('backend.transaction_management.payment.history', [
            'transactions' => $transactionsPaginated,
            'currentPage' => $page,
            'totalPages' => $totalPages,
        ]);
    }

    public function flowDiagram()
    {
        // Fetch last 5 sales returns with invoices and customer info
        $salesReturns = SalesReturn::with(['invoice.customer', 'items.product'])
            ->orderBy('return_date', 'desc')
            ->take(5)
            ->get();

        return view('backend.transaction_management.payment.flow_diagram', compact('salesReturns'));
    }

    public function edit(Payment $payment)
    {
        $invoices = Invoice::where('status', 0)->orWhere('id', $payment->invoice_id)->get();
        $users = User::all();
        return view('backend.transaction_management.payment.edit', compact('payment', 'invoices', 'users'));
    }

    public function update(Request $request, Payment $payment)
    {
        $request->validate([
            'payment_name' => 'required|string',
            'invoice_id'   => 'nullable|exists:invoices,id',
            'paid_amount'  => 'required|numeric|min:0',
            'due_amount'   => 'nullable|numeric|min:0',
            'paid_by'      => 'required|exists:users,id',
            'payment_type' => 'required|string',
        ]);

        // Keep old values for logging
        $oldPaymentData = $payment->only(['payment_name', 'invoice_id', 'paid_amount', 'due_amount', 'paid_by', 'payment_type']);

        // Update payment
        $payment->update([
            'payment_name' => $request->payment_name,
            'invoice_id'   => $request->invoice_id,
            'paid_amount'  => $request->paid_amount,
            'due_amount'   => $request->due_amount ?? 0,
            'paid_by'      => $request->paid_by,
            'payment_type' => $request->payment_type,
        ]);

        // Update invoice if linked
        if ($request->invoice_id) {
            $invoice = Invoice::find($request->invoice_id);
            $invoice->paid_amount = $request->paid_amount;
            $invoice->paid_by     = $request->paid_by;
            $invoice->status      = $request->paid_amount >= $invoice->total ? 1 : 0;
            $invoice->save();
        }

        // 🔥 Activity Log for update
        activity()
            ->causedBy(auth()->user())
            ->performedOn($payment)
            ->withProperties([
                'old' => $oldPaymentData,
                'new' => $payment->only(['payment_name', 'invoice_id', 'paid_amount', 'due_amount', 'paid_by', 'payment_type']),
            ])
            ->log('Payment Updated');

        return redirect()->route('payments.index')->with('success', 'Payment updated successfully');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();
        return redirect()->route('payments.index')->with('success', 'Payment deleted successfully');
    }
}
