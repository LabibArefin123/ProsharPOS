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
            'payment_method' => 'required|string',
            'transaction_id' => 'nullable|string',
            'note' => 'nullable|string',
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
            'payment_method' => $request->payment_method,
            'transaction_id' => $request->transaction_id,
            'note'           => $request->note,
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

        /*
    |--------------------------------------------------------------------------
    | Load Transactions
    |--------------------------------------------------------------------------
    */

        $loadTransactions = function (
            $model,
            $type,
            $relations,
            $actorRelation,
            $amountField,
            $dateField,
            $descriptionField,
            $userColumn = 'user_id'
        ) use ($isAdmin, $user) {

            $query = $model::query()->with($relations);

            // Non-admin users can only see their own user-linked transactions.
            if (!$isAdmin && $userColumn) {
                $query->where($userColumn, $user->id);
            }

            return $query->get()->map(function ($item) use (
                $type,
                $actorRelation,
                $amountField,
                $dateField,
                $descriptionField
            ) {
                return (object) [
                    'type' => $type,

                    'date' => $item->{$dateField},

                    'created_at' => $item->created_at,

                    'amount' => (float) $item->{$amountField},

                    'currency' => 'BDT',

                    'description' => data_get($item, $descriptionField)
                        ?: ucfirst(str_replace('_', ' ', $type)),

                    // Only actual users belong here.
                    'user' => $actorRelation
                        ? data_get($item, $actorRelation)
                        : null,

                    // Original transaction model.
                    'source' => $item,

                    'old_balance' => null,
                    'new_balance' => null,
                ];
            });
        };

        /*
    |--------------------------------------------------------------------------
    | User-Linked Transactions
    |--------------------------------------------------------------------------
    */

        $deposits = $loadTransactions(
            BankDeposit::class,
            'deposit',
            ['user'],
            'user',
            'amount',
            'deposit_date',
            'reference_no'
        );

        $withdraws = $loadTransactions(
            BankWithdraw::class,
            'withdraw',
            ['user'],
            'user',
            'amount',
            'withdraw_date',
            'reference_no'
        );

        $payments = $loadTransactions(
            Payment::class,
            'payment',
            ['paidBy'],
            'paidBy',
            'paid_amount',
            'created_at',
            'invoice_id',
            'paid_by'
        );

        /*
    |--------------------------------------------------------------------------
    | Supplier and Purchase Transactions
    |--------------------------------------------------------------------------
    */

        $supplierPayments = $loadTransactions(
            SupplierPayment::class,
            'supplier_payment',
            ['supplier', 'purchase'],
            null,
            'amount',
            'payment_date',
            'purchase.reference_no',
            null
        );

        $purchases = $loadTransactions(
            Purchase::class,
            'purchase',
            ['supplier'],
            null,
            'total_amount',
            'created_at',
            'reference_no',
            null
        );

        $returns = $loadTransactions(
            PurchaseReturn::class,
            'purchase_return',
            ['supplier'],
            null,
            'total_amount',
            'return_date',
            'reference_no',
            null
        );

        /*
    |--------------------------------------------------------------------------
    | Merge All Transactions
    |--------------------------------------------------------------------------
    */

        $transactions = collect()
            ->merge($deposits)
            ->merge($withdraws)
            ->merge($payments)
            ->merge($supplierPayments)
            ->merge($purchases)
            ->merge($returns);

        /*
    |--------------------------------------------------------------------------
    | Chronological Sorting
    |--------------------------------------------------------------------------
    */

        $sortKey = function ($transaction) {
            $date = $transaction->date
                ? \Carbon\Carbon::parse($transaction->date)->format('Ymd')
                : '00000000';

            $time = $transaction->created_at
                ? \Carbon\Carbon::parse($transaction->created_at)->format('His')
                : '000000';

            return $date . $time;
        };

        $transactions = $transactions
            ->sortByDesc($sortKey)
            ->values();

        /*
    |--------------------------------------------------------------------------
    | Running Balance Calculation
    |--------------------------------------------------------------------------
    |
    | bank_balances.balance represents the latest/current balance.
    |
    | Deposit         = + amount
    | Withdraw        = - amount
    | Customer Payment = - amount
    |
    | We process newest to oldest to reconstruct historical balances.
    |
    */

        $balanceTypes = [
            'deposit',
            'withdraw',
            'payment',
        ];

        if ($isAdmin) {

            /*
        |--------------------------------------------------------------------------
        | Admin / Accountant: Calculate Each User Separately
        |--------------------------------------------------------------------------
        */

            $userTransactions = $transactions
                ->filter(function ($transaction) use ($balanceTypes) {
                    return in_array($transaction->type, $balanceTypes)
                        && $transaction->user !== null;
                })
                ->groupBy(fn($transaction) => $transaction->user->id);

            $userIds = $userTransactions->keys()->all();

            $currentBalances = BankBalance::whereIn('user_id', $userIds)
                ->pluck('balance', 'user_id');

            $calculatedUserTransactions = $userTransactions->flatMap(
                function ($userTxs, $userId) use (
                    $currentBalances,
                    $sortKey
                ) {
                    // Current/latest balance of this particular user.
                    $runningBalance = (float) ($currentBalances[$userId] ?? 0);

                    // Newest transaction first.
                    return $userTxs
                        ->sortByDesc($sortKey)
                        ->values()
                        ->map(function ($transaction) use (&$runningBalance) {

                            $amount = abs((float) $transaction->amount);

                            $delta = match ($transaction->type) {
                                'deposit' => $amount,
                                'withdraw', 'payment' => -$amount,
                                default => 0,
                            };

                            // Balance immediately after this transaction.
                            $transaction->new_balance = $runningBalance;

                            // Balance immediately before this transaction.
                            $transaction->old_balance = $runningBalance - $delta;

                            // Move backward to the previous balance.
                            $runningBalance = $transaction->old_balance;

                            return $transaction;
                        });
                }
            );

            // Supplier and purchase transactions do not affect user balances.
            $nonUserTransactions = $transactions->filter(
                fn($transaction) => !in_array(
                    $transaction->type,
                    $balanceTypes
                )
            );

            $transactions = $calculatedUserTransactions
                ->merge($nonUserTransactions)
                ->sortByDesc($sortKey)
                ->values();
        } else {

            /*
        |--------------------------------------------------------------------------
        | Normal User: Own Running Balance
        |--------------------------------------------------------------------------
        */

            $runningBalance = (float) BankBalance::where(
                'user_id',
                $user->id
            )->value('balance');

            $transactions = $transactions->map(
                function ($transaction) use (&$runningBalance) {

                    if (!in_array($transaction->type, [
                        'deposit',
                        'withdraw',
                        'payment',
                    ])) {
                        return $transaction;
                    }

                    $amount = abs((float) $transaction->amount);

                    $delta = match ($transaction->type) {
                        'deposit' => $amount,
                        'withdraw', 'payment' => -$amount,
                        default => 0,
                    };

                    $transaction->new_balance = $runningBalance;

                    $transaction->old_balance = $runningBalance - $delta;

                    $runningBalance = $transaction->old_balance;

                    return $transaction;
                }
            );
        }

        /*
    |--------------------------------------------------------------------------
    | Pagination
    |--------------------------------------------------------------------------
    */

        $page = max(1, (int) request()->query('page', 1));

        $perPage = 5;

        $totalRecords = $transactions->count();

        $totalPages = (int) ceil($totalRecords / $perPage);

        $transactionsPaginated = $transactions
            ->slice(($page - 1) * $perPage, $perPage)
            ->values();

        return view(
            'backend.transaction_management.payment.history',
            [
                'transactions' => $transactionsPaginated,
                'currentPage' => $page,
                'totalPages' => $totalPages,
                'isAdmin' => $isAdmin,
            ]
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
            'payment_method' => 'required|string',
            'transaction_id' => 'nullable|string',
            'note' => 'nullable|string',
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
            'payment_method' => $request->payment_method,
            'transaction_id' => $request->transaction_id,
            'note'           => $request->note,
        ]);

        // Update invoice if linked
        if ($request->invoice_id) {
            $invoice = Invoice::find($request->invoice_id);
            $invoice->paid_amount = $request->paid_amount;
            $invoice->paid_by     = $request->paid_by;
            $invoice->status      = $request->paid_amount >= $invoice->total ? 1 : 0;
            $invoice->save();
        }

        return redirect()->route('payments.index')->with('success', 'Payment updated successfully');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();
        return redirect()->route('payments.index')->with('success', 'Payment deleted successfully');
    }
}
