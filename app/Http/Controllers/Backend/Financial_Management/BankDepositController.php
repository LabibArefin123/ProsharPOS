<?php

namespace App\Http\Controllers\Backend\Financial_Management;

use App\Http\Controllers\Controller;

use App\Models\BankBalance;
use App\Models\BankDeposit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class BankDepositController extends Controller
{
    // Show list of deposits
    public function index()
    {
        // STEP 1: Sync USD balances from deposits (safe recalculation)
        if (Schema::hasColumn('bank_balances', 'balance_in_dollars')) {

            BankBalance::query()->each(function ($bank) {
                $bank->update([
                    'balance_in_dollars' => BankDeposit::where(
                        'bank_balance_id',
                        $bank->id
                    )->sum('amount_in_dollar')
                ]);
            });
        }

        // STEP 2: Load deposits
        $deposits = BankDeposit::with(['bankBalance.user', 'user'])
            ->orderBy('id', 'asc')
            ->get();

        // STEP 3: Calculate adjusted balance (same logic as bank_balance index)
        $deposits->transform(function ($deposit) {

            $bank = $deposit->bankBalance;
            $totalPayments = $bank->user->payments()->sum('paid_amount');

            // Virtual value (NOT saved in DB)
            $deposit->adjusted_balance = $bank->balance - $totalPayments;

            return $deposit;
        });

        return view(
            'backend.financial_management.bank_deposit.index',
            compact('deposits')
        );
    }

    // Show create form
    public function create()
    {
        $users = User::all();
        $balances = BankBalance::with('user')->get();
        return view('backend.financial_management.bank_deposit.create', compact('users', 'balances'));
    }

    // Store new deposit
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'bank_balance_id'   => 'required|exists:bank_balances,id',
            'deposit_date'      => 'required|date',
            'amount'            => 'required|numeric|min:50',
            'amount_in_dollar'  => 'nullable|numeric|min:0',
            'deposit_method'    => 'required|string',
            'reference_no'      => 'required|string',
        ]);

        $amountBDT   = $request->amount;
        $amountUSD   = $request->amount_in_dollar ?? 0;
        $bankId      = $request->bank_balance_id;

        DB::transaction(function () use ($request, $amountBDT, $amountUSD, $bankId) {

            // Create deposit
            $deposit = BankDeposit::create([
                'bank_balance_id'   => $bankId,
                'user_id'           => auth()->id(),
                'deposit_date'      => $request->deposit_date,
                'amount'            => $amountBDT,
                'amount_in_dollar'  => $amountUSD,
                'deposit_method'    => $request->deposit_method,
                'reference_no'      => $request->reference_no,
                'note'              => $request->note,
            ]);

            // Update BDT balance
            $bankBalance = BankBalance::findOrFail($bankId);
            $bankBalance->increment('balance', $amountBDT);

            // Update USD balance if column exists
            if (Schema::hasColumn('bank_balances', 'balance_in_dollars')) {
                $bankBalance->increment('balance_in_dollars', $amountUSD);
            }
        });

        return redirect()
            ->route('bank_deposits.index')
            ->with('success', 'Deposit added successfully.');
    }

    public function show(BankDeposit $bankDeposit)
    {
        // Load relations safely
        $bankDeposit->load(['bankBalance.user', 'user']);

        $bank = $bankDeposit->bankBalance;

        // Same logic used everywhere
        $totalPayments = $bank->user->payments()->sum('paid_amount');

        // Virtual / calculated balance
        $adjustedBalance = $bank->balance - $totalPayments;

        return view(
            'backend.financial_management.bank_deposit.show',
            compact('bankDeposit', 'adjustedBalance')
        );
    }


    // Show edit form
    public function edit(BankDeposit $bankDeposit)
    {
        $users = User::all();
        $balances = BankBalance::with('user')->get();
        return view('backend.financial_management.bank_deposit.edit', compact('bankDeposit', 'users', 'balances'));
    }


    public function update(Request $request, BankDeposit $bankDeposit)
    {
        $request->validate([
            'bank_balance_id' => 'required|exists:bank_balances,id',
            'deposit_date' => 'required|date',
            'amount' => 'required|numeric|min:1',
            'amount_in_dollar' => 'nullable|numeric|min:0',
            'deposit_method' => 'required|string',
            'reference_no' => 'required|string',
        ]);

        // preserve old values
        $oldAmount = $bankDeposit->amount;
        $oldAmountInDollar = $bankDeposit->amount_in_dollar ?? 0;
        $oldBankBalanceId = $bankDeposit->bank_balance_id;

        // new values from request (normalize dollar to 0 if null)
        $newAmount = $request->amount;
        $newAmountInDollar = $request->amount_in_dollar ?? 0;
        $newBankBalanceId = $request->bank_balance_id;

        DB::transaction(function () use (
            $bankDeposit,
            $oldAmount,
            $oldAmountInDollar,
            $oldBankBalanceId,
            $newAmount,
            $newAmountInDollar,
            $newBankBalanceId,
            $request
        ) {
            // Update the deposit record
            $bankDeposit->update([
                'bank_balance_id'    => $newBankBalanceId,
                'deposit_date'       => $request->deposit_date,
                'amount'             => $newAmount,
                'amount_in_dollar'   => $newAmountInDollar,
                'deposit_method'     => $request->deposit_method,
                'reference_no'       => $request->reference_no,
                'note'               => $request->note,
            ]);

            // Adjust BDT balances
            if ($oldBankBalanceId != $newBankBalanceId) {
                // subtract old amount from old bank balance
                $oldBank = BankBalance::findOrFail($oldBankBalanceId);
                $oldBank->decrement('balance', $oldAmount);

                // add new amount to new bank balance
                $newBank = BankBalance::findOrFail($newBankBalanceId);
                $newBank->increment('balance', $newAmount);
            } else {
                // same bank: adjust difference
                $bank = BankBalance::findOrFail($newBankBalanceId);
                $bank->increment('balance', $newAmount - $oldAmount);
            }

            // Adjust USD balances only if column exists
            if (Schema::hasColumn('bank_balances', 'balance_in_dollars')) {
                if ($oldBankBalanceId != $newBankBalanceId) {
                    $oldBank = BankBalance::findOrFail($oldBankBalanceId);
                    $oldBank->decrement('balance_in_dollars', $oldAmountInDollar);

                    $newBank = BankBalance::findOrFail($newBankBalanceId);
                    $newBank->increment('balance_in_dollars', $newAmountInDollar);
                } else {
                    $bank = BankBalance::findOrFail($newBankBalanceId);
                    $bank->increment('balance_in_dollars', $newAmountInDollar - $oldAmountInDollar);
                }
            }
        });

        return redirect()
            ->route('bank_deposits.index')
            ->with('success', 'Deposit updated successfully.');
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
