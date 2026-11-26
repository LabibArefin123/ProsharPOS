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

        /* Load Transactions */
        $transactions = collect()
            ->merge($this->loadHistoryTransactions(
                BankDeposit::class,
                'deposit',
                ['user'],
                'user',
                'amount',
                'deposit_date',
                'reference_no',
                $isAdmin,
                $user
            ))
            ->merge($this->loadHistoryTransactions(
                BankWithdraw::class,
                'withdraw',
                ['user'],
                'user',
                'amount',
                'withdraw_date',
                'reference_no',
                $isAdmin,
                $user
            ))
            ->merge($this->loadHistoryTransactions(
                Payment::class,
                'payment',
                ['paidBy'],
                'paidBy',
                'paid_amount',
                'created_at',
                'invoice_id',
                $isAdmin,
                $user,
                'paid_by'
            ))
            ->merge($this->loadHistoryTransactions(
                SupplierPayment::class,
                'supplier_payment',
                ['supplier', 'purchase'],
                null,
                'amount',
                'payment_date',
                'purchase.reference_no',
                $isAdmin,
                $user,
                null
            ))
            ->merge($this->loadHistoryTransactions(
                Purchase::class,
                'purchase',
                ['supplier'],
                null,
                'total_amount',
                'created_at',
                'reference_no',
                $isAdmin,
                $user,
                null
            ))
            ->merge($this->loadHistoryTransactions(
                PurchaseReturn::class,
                'purchase_return',
                ['supplier'],
                null,
                'total_amount',
                'return_date',
                'reference_no',
                $isAdmin,
                $user,
                null
            ));

        /* Sort Transactions  */

        $transactions = $this->sortHistoryTransactions($transactions);

        /* Calculate Running Balances*/
        $transactions = $this->calculateHistoryBalances(
            $transactions,
            $isAdmin,
            $user
        );

        /* Pagination*/
        $pagination = $this->paginateHistoryTransactions($transactions);

        return view(
            'backend.transaction_management.payment.history',
            [
                'transactions' => $pagination['transactions'],
                'currentPage' => $pagination['currentPage'],
                'totalPages' => $pagination['totalPages'],
                'isAdmin' => $isAdmin,
            ]
        );
    }


    /* 1. Load Transaction Records*/
    private function loadHistoryTransactions(
        $model,
        string $type,
        array $relations,
        ?string $actorRelation,
        string $amountField,
        string $dateField,
        string $descriptionField,
        bool $isAdmin,
        $user,
        ?string $userColumn = 'user_id'
    ) {
        $query = $model::query()->with($relations);

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
            $amount = abs((float) data_get($item, $amountField, 0));

            $config = $this->getHistoryTransactionConfig($type);

            return (object) [
                'type' => $type,

                'date' => data_get($item, $dateField),

                'created_at' => $item->created_at,

                'amount' => $amount,

                'formatted_amount' => number_format($amount, 2),

                'currency' => 'BDT',

                'description' => data_get($item, $descriptionField)
                    ?: ucfirst(str_replace('_', ' ', $type)),

                'user' => $actorRelation
                    ? data_get($item, $actorRelation)
                    : null,

                'source' => $item,

                'old_balance' => null,
                'new_balance' => null,

                // Presentation data for Blade.
                'label' => $config['label'],
                'sign' => $config['sign'],
                'class' => $config['class'],
                'icon' => $config['icon'],
            ];
        });
    }


    /*2. Transaction Presentation Configuration*/
    private function getHistoryTransactionConfig(string $type): array
    {
        $config = [
            'deposit' => [
                'label' => 'Deposit',
                'sign' => '+',
                'class' => 'deposit',
                'icon' => 'fa-arrow-down',
            ],

            'withdraw' => [
                'label' => 'Withdraw',
                'sign' => '-',
                'class' => 'withdraw',
                'icon' => 'fa-arrow-up',
            ],

            'payment' => [
                'label' => 'Customer Payment',
                'sign' => '-',
                'class' => 'payment',
                'icon' => 'fa-money-bill-wave',
            ],

            'supplier_payment' => [
                'label' => 'Supplier Payment',
                'sign' => '-',
                'class' => 'supplier-payment',
                'icon' => 'fa-truck',
            ],

            'purchase' => [
                'label' => 'Purchase',
                'sign' => '-',
                'class' => 'purchase',
                'icon' => 'fa-cart-shopping',
            ],

            'purchase_return' => [
                'label' => 'Purchase Return',
                'sign' => '+',
                'class' => 'purchase-return',
                'icon' => 'fa-rotate-left',
            ],
        ];

        return $config[$type] ?? [
            'label' => ucfirst(str_replace('_', ' ', $type)),
            'sign' => '',
            'class' => 'neutral',
            'icon' => 'fa-circle-info',
        ];
    }


    /*3. Sort Transactions Chronologically*/
    private function sortHistoryTransactions($transactions)
    {
        return $transactions
            ->sortByDesc(function ($transaction) {
                $date = $transaction->date
                    ? \Carbon\Carbon::parse($transaction->date)->format('Ymd')
                    : '00000000';

                $time = $transaction->created_at
                    ? \Carbon\Carbon::parse($transaction->created_at)->format('His')
                    : '000000';

                return $date . $time;
            })
            ->values();
    }


    /*4. Calculate Historical Balances*/
    private function calculateHistoryBalances($transactions, bool $isAdmin, $user)
    {
        $balanceTypes = ['deposit', 'withdraw', 'payment',];

        if ($isAdmin) {
            // Group user-linked balance transactions by user.
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
                function ($userTxs, $userId) use ($currentBalances) {

                    $runningBalance = (float) ($currentBalances[$userId] ?? 0);

                    return $userTxs
                        ->sortByDesc(function ($transaction) {
                            $date = $transaction->date
                                ? \Carbon\Carbon::parse($transaction->date)->format('Ymd')
                                : '00000000';

                            $time = $transaction->created_at
                                ? \Carbon\Carbon::parse($transaction->created_at)->format('His')
                                : '000000';

                            return $date . $time;
                        })
                        ->values()
                        ->map(function ($transaction) use (&$runningBalance) {

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
                        });
                }
            );

            // Transactions without user balance calculations.
            $nonUserTransactions = $transactions->filter(
                fn($transaction) => !in_array(
                    $transaction->type,
                    $balanceTypes
                )
            );

            return $calculatedUserTransactions
                ->merge($nonUserTransactions)
                ->sortByDesc(function ($transaction) {
                    $date = $transaction->date
                        ? \Carbon\Carbon::parse($transaction->date)->format('Ymd')
                        : '00000000';

                    $time = $transaction->created_at
                        ? \Carbon\Carbon::parse($transaction->created_at)->format('His')
                        : '000000';

                    return $date . $time;
                })
                ->values();
        }

        // Normal user: calculate their own balance.
        $runningBalance = (float) BankBalance::where('user_id', $user->id)->value('balance');

        return $transactions->map(function ($transaction) use (
            &$runningBalance,
            $balanceTypes
        ) {
            if (!in_array($transaction->type, $balanceTypes)) {
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
        });
    }


    /* 5. Paginate Transaction Records*/
    private function paginateHistoryTransactions($transactions): array
    {
        $page = max(1, (int) request()->query('page', 1));
        $perPage = 5;
        $totalRecords = $transactions->count();
        $totalPages = (int) ceil($totalRecords / $perPage);

        // Keep page within the valid range.
        $totalPages = max(1, $totalPages);
        $page = min($page, $totalPages);

        $transactionsPaginated = $transactions
            ->slice(($page - 1) * $perPage, $perPage)
            ->values();

        return [
            'transactions' => $transactionsPaginated,
            'currentPage' => $page,
            'totalPages' => $totalPages,
        ];
    }

    public function flowDiagram()
    {
        $salesReturns = SalesReturn::with([
            'invoice.customer',
            'invoice.invoiceItems',
            'items.product',
        ])
            ->orderByDesc('return_date')
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        return view(
            'backend.transaction_management.payment.flow_diagram',
            compact('salesReturns')
        );
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
