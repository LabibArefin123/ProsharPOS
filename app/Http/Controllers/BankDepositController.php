<?php

namespace App\Http\Controllers;

use App\Models\BankBalance;
use App\Models\BankDeposit;
use App\Models\User;
use Illuminate\Http\Request;

class BankDepositController extends Controller
{
    // Show list of deposits
    public function index()
    {
        $deposits = BankDeposit::with('bankBalance.user', 'user')->orderBy('id', 'asc')->get();
        return view('transaction_management.bank_deposit.index', compact('deposits'));
    }

    // Show create form
    public function create()
    {
        $users = User::all();
        $balances = BankBalance::with('user')->get();
        return view('transaction_management.bank_deposit.create', compact('users', 'balances'));
    }

    // Store new deposit
    public function store(Request $request)
    {
        $request->validate([
            'bank_balance_id' => 'required|exists:bank_balances,id',
            'deposit_date' => 'required|date',
            'amount' => 'required|numeric|min:1',
            'deposit_method' => 'required|string',
            'reference_no' => 'required|string',
        ]);

        $deposit = BankDeposit::create([
            'bank_balance_id' => $request->bank_balance_id,
            'user_id' => auth()->id(),
            'deposit_date' => $request->deposit_date,
            'amount' => $request->amount,
            'deposit_method' => $request->deposit_method,
            'reference_no' => $request->reference_no,
            'note' => $request->note,
        ]);

        // Update bank balance automatically
        $bankBalance = BankBalance::findOrFail($request->bank_balance_id);
        $bankBalance->increment('balance', $deposit->amount);

        return redirect()->route('bank_deposits.index')->with('success', 'Deposit added successfully.');
    }

    public function show(BankDeposit $bankDeposit)
    {
        return view('transaction_management.bank_deposit.show', compact('bankDeposit'));
    }

    // Show edit form
    public function edit(BankDeposit $bankDeposit)
    {
        $users = User::all();
        $balances = BankBalance::with('user')->get();
        return view('transaction_management.bank_deposit.edit', compact('bankDeposit', 'users', 'balances'));
    }

    // Update deposit
    public function update(Request $request, BankDeposit $bankDeposit)
    {
        $request->validate([
            'bank_balance_id' => 'required|exists:bank_balances,id',
            'deposit_date' => 'required|date',
            'amount' => 'required|numeric|min:1',
            'deposit_method' => 'required|string',
            'reference_no' => 'required|string',
        ]);

        $oldAmount = $bankDeposit->amount;

        $bankDeposit->update([
            'bank_balance_id' => $request->bank_balance_id,
            'deposit_date' => $request->deposit_date,
            'amount' => $request->amount,
            'deposit_method' => $request->deposit_method,
            'reference_no' => $request->reference_no,
            'note' => $request->note,
        ]);

        // Adjust bank balance
        $bankBalance = BankBalance::findOrFail($request->bank_balance_id);
        $bankBalance->increment('balance', $request->amount - $oldAmount);

        return redirect()->route('bank_deposits.index')->with('success', 'Deposit updated successfully.');
    }

    // Delete deposit
    public function destroy(BankDeposit $bankDeposit)
    {
        $bankBalance = BankBalance::findOrFail($bankDeposit->bank_balance_id);
        $bankBalance->decrement('balance', $bankDeposit->amount);

        $bankDeposit->delete();
        return redirect()->route('bank_deposits.index')->with('success', 'Deposit deleted successfully.');
    }
}
