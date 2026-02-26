<?php

namespace App\Http\Controllers\Backend\Financial_Management;
use App\Http\Controllers\Controller;
use App\Models\BankCard;
use App\Models\BankBalance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
class BankCardController extends Controller
{
    public function index()
    {
        $cards = BankCard::with(['bankBalance.user', 'user'])->orderBy('id', 'desc')->get();
        return view('backend.financial_management.bank_card.index', compact('cards'));
    }

    public function create()
    {
        $banks = BankBalance::with('user')->get();
        return view('backend.financial_management.bank_card.create', compact('banks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bank_balance_id' => 'required|exists:bank_balances,id',
            'payment_date' => 'required|date',
            'card_type' => 'required|string',
            'card_holder_name' => 'required|string',
            'card_last_four' => 'required|digits:4',
            'amount' => 'required|numeric|min:50',
            'amount_in_dollar' => 'nullable|numeric|min:0',
            'reference_no' => 'required|string|unique:bank_cards,reference_no',
            'note' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request) {
            $card = BankCard::create([
                'bank_balance_id' => $request->bank_balance_id,
                'user_id' => Auth::id(),
                'payment_date' => $request->payment_date,
                'card_type' => $request->card_type,
                'card_holder_name' => $request->card_holder_name,
                'card_last_four' => $request->card_last_four,
                'amount' => $request->amount,
                'amount_in_dollar' => $request->amount_in_dollar ?? 0,
                'reference_no' => $request->reference_no,
                'note' => $request->note,
            ]);

            $bank = BankBalance::findOrFail($request->bank_balance_id);
            $bank->increment('balance', $request->amount);
            if (Schema::hasColumn('bank_balances', 'balance_in_dollars')) {
                $bank->increment('balance_in_dollars', $request->amount_in_dollar ?? 0);
            }
        });

        return redirect()->route('bank_cards.index')->with('success', 'Card payment recorded successfully.');
    }

    public function show(BankCard $bankCard)
    {
        $bankCard->load(['bankBalance.user', 'user']);
        return view('backend.financial_management.bank_card.show', compact('bankCard'));
    }

    public function edit(BankCard $bankCard)
    {
        $banks = BankBalance::with('user')->get();
        return view('backend.financial_management.bank_card.edit', compact('bankCard', 'banks'));
    }

    public function update(Request $request, BankCard $bankCard)
    {
        $request->validate([
            'bank_balance_id' => 'required|exists:bank_balances,id',
            'payment_date' => 'required|date',
            'card_type' => 'required|string',
            'card_holder_name' => 'required|string',
            'card_last_four' => 'required|digits:4',
            'amount' => 'required|numeric|min:1',
            'amount_in_dollar' => 'nullable|numeric|min:0',
            'reference_no' => 'required|string|unique:bank_cards,reference_no,' . $bankCard->id,
            'note' => 'nullable|string',
        ]);

        $oldAmount = $bankCard->amount;
        $oldAmountUSD = $bankCard->amount_in_dollar ?? 0;
        $oldBankId = $bankCard->bank_balance_id;

        $newAmount = $request->amount;
        $newAmountUSD = $request->amount_in_dollar ?? 0;
        $newBankId = $request->bank_balance_id;

        DB::transaction(function () use ($bankCard, $oldAmount, $oldAmountUSD, $oldBankId, $newAmount, $newAmountUSD, $newBankId, $request) {

            $bankCard->update([
                'bank_balance_id' => $newBankId,
                'payment_date' => $request->payment_date,
                'card_type' => $request->card_type,
                'card_holder_name' => $request->card_holder_name,
                'card_last_four' => $request->card_last_four,
                'amount' => $newAmount,
                'amount_in_dollar' => $newAmountUSD,
                'reference_no' => $request->reference_no,
                'note' => $request->note,
            ]);

            if ($oldBankId != $newBankId) {
                BankBalance::findOrFail($oldBankId)->decrement('balance', $oldAmount);
                BankBalance::findOrFail($newBankId)->increment('balance', $newAmount);

                if (Schema::hasColumn('bank_balances', 'balance_in_dollars')) {
                    BankBalance::findOrFail($oldBankId)->decrement('balance_in_dollars', $oldAmountUSD);
                    BankBalance::findOrFail($newBankId)->increment('balance_in_dollars', $newAmountUSD);
                }
            } else {
                $bank = BankBalance::findOrFail($newBankId);
                $bank->increment('balance', $newAmount - $oldAmount);
                if (Schema::hasColumn('bank_balances', 'balance_in_dollars')) {
                    $bank->increment('balance_in_dollars', $newAmountUSD - $oldAmountUSD);
                }
            }
        });

        return redirect()->route('bank_cards.index')->with('success', 'Card payment updated successfully.');
    }

    public function destroy(BankCard $bankCard)
    {
        $bank = BankBalance::findOrFail($bankCard->bank_balance_id);
        $bank->decrement('balance', $bankCard->amount);
        if (Schema::hasColumn('bank_balances', 'balance_in_dollars')) {
            $bank->decrement('balance_in_dollars', $bankCard->amount_in_dollar ?? 0);
        }
        $bankCard->delete();
        return redirect()->route('bank_cards.index')->with('success', 'Card payment deleted successfully.');
    }
}