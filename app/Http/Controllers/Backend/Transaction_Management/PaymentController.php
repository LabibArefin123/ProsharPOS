<?php

namespace App\Http\Controllers\Backend\Transaction_Management;

use App\Http\Controllers\Controller;
use App\Models\BankBalance;
use App\Models\BankDeposit;
use App\Models\BankWithdraw;
use App\Models\SalesReturn;
use App\Models\Payment;
use App\Models\Purchase;
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
        // Load deposits
        $deposits = BankDeposit::with(['bankBalance.user', 'user'])
            ->orderBy('deposit_date', 'desc')
            ->get()
            ->map(function ($d) {
                return (object)[
                    'type' => 'deposit',
                    'date' => $d->deposit_date,
                    'amount' => $d->amount,
                    'currency' => 'BDT',
                    'description' => $d->reference_no,
                    'user' => $d->user,
                    'bankBalance' => $d->bankBalance,
                ];
            });

        // Load withdrawals
        $withdraws = BankWithdraw::with(['bankBalance.user', 'user'])
            ->orderBy('withdraw_date', 'desc')
            ->get()
            ->map(function ($w) {
                return (object)[
                    'type' => 'withdraw',
                    'date' => $w->withdraw_date,
                    'amount' => $w->amount,
                    'currency' => 'BDT',
                    'description' => $w->reference_no,
                    'user' => $w->user,
                    'bankBalance' => $w->bankBalance,
                ];
            });

        // Load fully paid payments (excluding purchase payments)
        $payments = Payment::with(['invoice.customer', 'paidBy'])
            ->whereHas('invoice', fn($q) => $q->where('status', 1))
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($p) {
                return (object)[
                    'type' => 'payment',
                    'date' => $p->created_at,
                    'amount' => $p->paid_amount,
                    'currency' => 'BDT',
                    'description' => $p->invoice->invoice_id ?? 'Payment',
                    'user' => $p->paidBy,
                    'payment' => $p,
                ];
            });

        // Load purchases (count only once per purchase)
        $purchases = Purchase::with('supplier')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($pu) {
                return (object)[
                    'type' => 'purchase',
                    'date' => $pu->created_at,
                    'amount' => $pu->total_amount,
                    'currency' => 'BDT',
                    'description' => $pu->purchase_id ?? 'Purchase',
                    'user' => $pu->supplier,
                ];
            });

        // Merge all transactions
        $transactions = $deposits->merge($withdraws)->merge($payments)->merge($purchases)
            ->sortByDesc('date'); // latest first

        // Start running balance from latest bank balance
        $latestBank = BankBalance::latest('id')->first();
        $runningBalance = $latestBank?->balance ?? 0;

        return view(
            'backend.transaction_management.payment.history',
            compact('transactions', 'runningBalance')
        );
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
