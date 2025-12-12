<?php

namespace App\Http\Controllers\Backend\Financial_Management;
use App\Http\Controllers\Controller;

use App\Models\BankBalance;
use App\Models\BankWithdraw;
use App\Models\User;
use Illuminate\Http\Request;

class BankWithdrawController extends Controller
{
    // Show list of withdrawals
    public function index()
    {
        $withdraws = BankWithdraw::with('bankBalance.user', 'user')->latest()->get();
        return view('backend.financial_management.bank_withdraw.index', compact('withdraws'));
    }

    // Show create form
    public function create()
    {
        $users = User::all();
        $balances = BankBalance::with('user')->get();
        return view('backend.financial_management.bank_withdraw.create', compact('users', 'balances'));
    }

    // Store new withdraw
    public function store(Request $request)
    {
        $request->validate([
            'bank_balance_id' => 'required|exists:bank_balances,id',
            'withdraw_date' => 'required|date',
            'amount' => 'required|numeric|min:1',
            'withdraw_method' => 'required|string',
        ]);

        $bankBalance = BankBalance::findOrFail($request->bank_balance_id);

        // Prevent negative balance
        if ($request->amount > $bankBalance->balance) {
            return redirect()->back()->withErrors('Withdrawal amount exceeds current balance.');
        }

        $withdraw = BankWithdraw::create([
            'bank_balance_id' => $request->bank_balance_id,
            'user_id' => auth()->id(),
            'withdraw_date' => $request->withdraw_date,
            'amount' => $request->amount,
            'withdraw_method' => $request->withdraw_method,
            'reference_no' => $request->reference_no,
            'note' => $request->note,
        ]);

        // Reduce bank balance automatically
        $bankBalance->decrement('balance', $withdraw->amount);

        return redirect()->route('bank_withdraws.index')->with('success', 'Withdrawal added successfully.');
    }

    public function show(BankWithdraw $bankWithdraw)
    {
        return view('backend.financial_management.bank_withdraw.show', compact('bankWithdraw'));
    }

    // Show edit form
    public function edit(BankWithdraw $bankWithdraw)
    {
        $users = User::all();
        $balances = BankBalance::with('user')->get();
        return view('backend.financial_management.bank_withdraw.edit', compact('bankWithdraw', 'users', 'balances'));
    }

    // Update withdrawal
    public function update(Request $request, BankWithdraw $bankWithdraw)
    {
        $request->validate([
            'bank_balance_id' => 'required|exists:bank_balances,id',
            'withdraw_date' => 'required|date',
            'amount' => 'required|numeric|min:1',
            'withdraw_method' => 'required|string',
        ]);

        $oldAmount = $bankWithdraw->amount;

        $bankWithdraw->update([
            'bank_balance_id' => $request->bank_balance_id,
            'withdraw_date' => $request->withdraw_date,
            'amount' => $request->amount,
            'withdraw_method' => $request->withdraw_method,
            'reference_no' => $request->reference_no,
            'note' => $request->note,
        ]);

        $bankBalance = BankBalance::findOrFail($request->bank_balance_id);

        // Adjust balance (old - new)
        $bankBalance->increment('balance', $oldAmount - $request->amount);

        return redirect()->route('bank_withdraws.index')->with('success', 'Withdrawal updated successfully.');
    }

    // Delete withdrawal
    public function destroy(BankWithdraw $bankWithdraw)
    {
        $bankBalance = BankBalance::findOrFail($bankWithdraw->bank_balance_id);
        $bankBalance->increment('balance', $bankWithdraw->amount);

        $bankWithdraw->delete();
        return redirect()->route('bank_withdraws.index')->with('success', 'Withdrawal deleted successfully.');
    }
}
