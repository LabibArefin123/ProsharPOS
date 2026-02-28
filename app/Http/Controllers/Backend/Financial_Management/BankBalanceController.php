<?php

namespace App\Http\Controllers\Backend\Financial_Management;

use App\Http\Controllers\Controller;
use App\Models\BankBalance;
use App\Models\Purchase;
use App\Models\PurchaseReturn;
use App\Models\SupplierPayment;
use App\Models\User;
use Illuminate\Http\Request;

class BankBalanceController extends Controller
{
    public function index()
    {
        $balances = BankBalance::with([
            'user.payments',    // payments made by user
            'deposits',         // deposits into this bank balance
            'withdraws',        // withdrawals from this bank balance
        ])->get();

        $balances->each(function ($balance) {

            // Original DB balance
            $balance->original_balance = $balance->balance;

            // Total deposits (money IN)
            $totalDeposits = $balance->deposits->sum('amount');

            // Total withdrawals (money OUT)
            $totalWithdraws = $balance->withdraws->sum('amount');

            // Total customer payments (money OUT)
            $totalPayments = $balance->user
                ? $balance->user->payments->sum('paid_amount')
                : 0;

            // Total purchases where this user is supplier (money OUT)
            $totalPurchases = Purchase::where('supplier_id', $balance->user_id ?? 0)
                ->sum('total_amount');

            // Total purchase returns where this user is supplier (money IN)
            $totalPurchaseReturns = PurchaseReturn::where('supplier_id', $balance->user_id ?? 0)
                ->sum('total_amount');

            // Total supplier payments (money OUT)
            $totalSupplierPayments = SupplierPayment::where('supplier_id', $balance->user_id ?? 0)
                ->sum('amount');

            // Compute final system balance
            // Logic: Original + Deposits + Purchase Returns - Withdrawals - Payments - Purchases - Supplier Payments
            $balance->system_balance = $balance->balance
                + $totalDeposits
                + $totalPurchaseReturns
                - $totalWithdraws
                - $totalPayments
                - $totalPurchases
                - $totalSupplierPayments;
        });

        return view(
            'backend.financial_management.bank_balance.index',
            compact('balances')
        );
    }

    public function create()
    {
        $users = User::all();
        return view('backend.financial_management.bank_balance.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'balance' => 'required|numeric|min:0',
            'balance_in_dollars' => 'nullable|numeric|min:0',
        ]);

        BankBalance::create($request->all());

        return redirect()->route('bank_balances.index')->with('success', 'Balance added successfully.');
    }

    public function show(BankBalance $bank_balance)
    {
        // Load all relationships
        $bank_balance->load([
            'user.payments',
            'deposits',
            'withdraws',
        ]);

        // Original DB balance
        $bank_balance->original_balance = $bank_balance->balance;

        // Total deposits (money IN)
        $totalDeposits = $bank_balance->deposits->sum('amount');

        // Total withdrawals (money OUT)
        $totalWithdraws = $bank_balance->withdraws->sum('amount');

        // Total customer payments (money OUT)
        $totalPayments = $bank_balance->user
            ? $bank_balance->user->payments->sum('paid_amount')
            : 0;

        // Total purchases (money OUT)
        $totalPurchases = Purchase::where('supplier_id', $bank_balance->user_id ?? 0)
            ->sum('total_amount');

        // Total purchase returns (money IN)
        $totalPurchaseReturns = PurchaseReturn::where('supplier_id', $bank_balance->user_id ?? 0)
            ->sum('total_amount');

        // Total supplier payments (money OUT)
        $totalSupplierPayments = SupplierPayment::where('supplier_id', $bank_balance->user_id ?? 0)
            ->sum('amount');

        // Compute final system balance
        $bank_balance->system_balance = $bank_balance->balance
            + $totalDeposits
            + $totalPurchaseReturns
            - $totalWithdraws
            - $totalPayments
            - $totalPurchases
            - $totalSupplierPayments;

        return view(
            'backend.financial_management.bank_balance.show',
            compact('bank_balance')
        );
    }
    
    public function edit(BankBalance $bank_balance)
    {
        // Load all relationships
        $bank_balance->load([
            'user.payments',
            'deposits',
            'withdraws',
        ]);

        // Original DB balance
        $bank_balance->original_balance = $bank_balance->balance;

        // Total deposits (money IN)
        $totalDeposits = $bank_balance->deposits->sum('amount');

        // Total withdrawals (money OUT)
        $totalWithdraws = $bank_balance->withdraws->sum('amount');

        // Total customer payments (money OUT)
        $totalPayments = $bank_balance->user
            ? $bank_balance->user->payments->sum('paid_amount')
            : 0;

        // Total purchases (money OUT)
        $totalPurchases = Purchase::where('supplier_id', $bank_balance->user_id ?? 0)
            ->sum('total_amount');

        // Total purchase returns (money IN)
        $totalPurchaseReturns = PurchaseReturn::where('supplier_id', $bank_balance->user_id ?? 0)
            ->sum('total_amount');

        // Total supplier payments (money OUT)
        $totalSupplierPayments = SupplierPayment::where('supplier_id', $bank_balance->user_id ?? 0)
            ->sum('amount');

        // Compute final system balance
        $bank_balance->system_balance = $bank_balance->balance
            + $totalDeposits
            + $totalPurchaseReturns
            - $totalWithdraws
            - $totalPayments
            - $totalPurchases
            - $totalSupplierPayments;

        // Users dropdown for edit form
        $users = User::orderBy('name', 'asc')->get();

        return view(
            'backend.financial_management.bank_balance.edit',
            compact('bank_balance', 'users')
        );
    }

    public function update(Request $request, BankBalance $bank_balance)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'balance' => 'required|numeric|min:0',
            'balance_in_dollars' => 'nullable|numeric|min:0',
        ]);

        $bank_balance->update($request->all());

        return redirect()->route('bank_balances.index')->with('success', 'Balance updated successfully.');
    }

    public function destroy(BankBalance $bank_balance)
    {
        $bank_balance->delete();
        return redirect()->route('bank_balances.index')->with('success', 'Balance deleted successfully.');
    }
}
