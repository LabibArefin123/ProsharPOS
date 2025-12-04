<?php

namespace App\Http\Controllers;

use App\Models\BankBalance;
use App\Models\User;
use Illuminate\Http\Request;

class BankBalanceController extends Controller
{
    public function index()
    {
        $balances = BankBalance::with('user')->get();
        return view('transaction_management.bank_balance.index', compact('balances'));
    }

    public function create()
    {
        $users = User::all();
        return view('transaction_management.bank_balance.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'balance' => 'required|numeric|min:0',
        ]);

        BankBalance::create($request->all());

        return redirect()->route('bank_balances.index')->with('success', 'Balance added successfully.');
    }

    public function show(BankBalance $bank_balance)
    {
        return view('transaction_management.bank_balance.show', compact('bank_balance'));
    }

    public function edit(BankBalance $bank_balance)
    {
        $users = User::all();
        return view('transaction_management.bank_balance.edit', compact('bank_balance', 'users'));
    }

    public function update(Request $request, BankBalance $bank_balance)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'balance' => 'required|numeric|min:0',
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
