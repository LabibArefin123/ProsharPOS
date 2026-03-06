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
        $user = auth()->user();
        $isAdmin = $user->hasRole('admin') || $user->hasRole('accountant');

        // Helper to load transactions
        $loadTransactions = fn($model, $type, $relationUserField, $amountField, $dateField, $descField, $userColumn = 'user_id') =>
        $model::with([$relationUserField])
            ->when(!$isAdmin && $userColumn, fn($q) => $q->where($userColumn, $user->id))
            ->get()
            ->map(fn($item) => (object)[
                'type'        => $type,
                'date'        => $item->$dateField,
                'created_at'  => $item->created_at,
                'amount'      => (float) $item->$amountField,
                'currency'    => 'BDT',
                'description' => $item->$descField ?? ucfirst($type),
                'user'        => $item->$relationUserField, // null for supplier/purchase
                'source'      => $item,
                'old_balance' => null,
                'new_balance' => null,
            ]);

        // User-linked transactions
        $deposits  = $loadTransactions(BankDeposit::class, 'deposit', 'user', 'amount', 'deposit_date', 'reference_no');
        $withdraws = $loadTransactions(BankWithdraw::class, 'withdraw', 'user', 'amount', 'withdraw_date', 'reference_no');
        $payments  = $loadTransactions(Payment::class, 'payment', 'paidBy', 'paid_amount', 'created_at', 'invoice_id', 'paid_by');

        // Supplier/purchase related transactions
        $supplierPayments = $loadTransactions(SupplierPayment::class, 'supplier_payment', 'supplier', 'amount', 'payment_date', 'purchase.reference_no', null);
        $purchases        = $loadTransactions(Purchase::class, 'purchase', 'supplier', 'total_amount', 'created_at', 'reference_no', null);
        $returns          = $loadTransactions(PurchaseReturn::class, 'purchase_return', 'supplier', 'total_amount', 'return_date', 'reference_no', null);

        // Merge all
        $transactions = collect()
            ->merge($deposits)
            ->merge($withdraws)
            ->merge($payments)
            ->merge($supplierPayments)
            ->merge($purchases)
            ->merge($returns)
            ->sortByDesc('created_at')
            ->values();

        // --- Running Balance ---
        if (!$isAdmin) {
            // Non-admin: only own user balance
            $runningBalance = BankBalance::where('user_id', $user->id)->sum('balance');

            $transactions = $transactions->map(function ($t) use (&$runningBalance) {
                $amount = abs($t->amount);

                if (in_array($t->type, ['deposit', 'withdraw', 'payment'])) {
                    $t->new_balance = $runningBalance;
                    $t->old_balance = in_array($t->type, ['withdraw', 'payment']) ? $runningBalance + $amount : $runningBalance - $amount;
                    $runningBalance = $t->old_balance;
                }

                // Non-user transactions already have null balances
                return $t;
            });
        } else {
            // Admin: only users with a role
            $userTransactions = $transactions
                ->filter(fn($t) => in_array($t->type, ['deposit', 'withdraw', 'payment']) && $t->user?->roles?->isNotEmpty())
                ->groupBy(fn($t) => $t->user->id)
                ->flatMap(function ($userTxs) {
                    $userModel = $userTxs->first()->user;
                    $runningBalance = $userModel?->bankBalances?->sum('balance') ?? 0;

                    return $userTxs->sortBy('created_at')->map(function ($t) use (&$runningBalance) {
                        $amount = abs($t->amount);
                        $t->new_balance = $runningBalance;
                        $t->old_balance = in_array($t->type, ['withdraw', 'payment']) ? $runningBalance + $amount : $runningBalance - $amount;
                        $runningBalance = $t->old_balance;
                        return $t;
                    });
                });

            // Non-user transactions: keep null balances
            $nonUserTransactions = $transactions->filter(fn($t) => !in_array($t->type, ['deposit', 'withdraw', 'payment']));

            $transactions = $userTransactions->merge($nonUserTransactions)
                ->sortByDesc('created_at')
                ->values();
        }

        // Pagination
        $page = request()->get('page', 1);
        $perPage = 5;
        $transactionsPaginated = $transactions->slice(($page - 1) * $perPage, $perPage)->values();
        $totalPages = ceil($transactions->count() / $perPage);

        return view('backend.transaction_management.payment.history', [
            'transactions' => $transactionsPaginated,
            'currentPage'  => $page,
            'totalPages'   => $totalPages,
            'isAdmin'      => $isAdmin,
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
