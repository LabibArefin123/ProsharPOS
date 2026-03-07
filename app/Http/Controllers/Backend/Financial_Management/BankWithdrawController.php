<?php

namespace App\Http\Controllers\Backend\Financial_Management;

use App\Http\Controllers\Controller;

use App\Models\BankBalance;
use App\Models\BankWithdraw;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BankWithdrawController extends Controller
{
    // Show list of withdrawals
    public function index()
    {
        $user = auth()->user();

        $withdrawQuery = BankWithdraw::with('bankBalance.user', 'user')->latest();

        // Only admin sees all
        if (!$user->hasRole('admin')) {
            // Get IDs of all users with the same role as current user
            $roleUsersIds = $user->getRoleNames()->flatMap(function ($roleName) {
                return \Spatie\Permission\Models\Role::where('name', $roleName)
                    ->first()
                    ->users()
                    ->pluck('id');
            })->unique()->toArray();

            $withdrawQuery->whereIn('user_id', $roleUsersIds);
        }

        $withdraws = $withdrawQuery->get();

        return view('backend.financial_management.bank_withdraw.index', compact('withdraws'));
    }

    // Show create form
    public function create()
    {
        $user = auth()->user();

        if ($user->hasRole('admin')) {

            $users = User::all();

            $balances = BankBalance::with(['user'])
                ->get();
        } else {

            $users = collect([$user]); // only himself

            $balances = BankBalance::with(['user'])
                ->where('user_id', $user->id)
                ->get();
        }

        $balancesData = $balances->map(function ($balance) {

            return [
                'id' => $balance->id,
                'user_id' => $balance->user_id,
                'original_balance' => $balance->balance,
            ];
        });

        return view(
            'backend.financial_management.bank_withdraw.create',
            compact('users', 'balances', 'balancesData')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'bank_balance_id' => 'nullable|exists:bank_balances,id',
            'withdraw_date'   => 'required|date',
            'amount'          => 'required|numeric|min:1',
            'withdraw_method' => 'required|string',
        ]);

        $user = auth()->user();

        // Admin selects bank manually
        if ($user->hasRole('admin')) {

            $bankBalance = BankBalance::findOrFail($request->bank_balance_id);
        } else {

            // Non-admin automatically uses their own bank
            $bankBalance = BankBalance::where('user_id', $user->id)->first();

            if (!$bankBalance) {
                return back()->withErrors('No bank balance found for this user.');
            }
        }

        // Prevent negative balance
        if ($request->amount > $bankBalance->balance) {
            return back()->withErrors('Withdrawal amount exceeds current balance.');
        }

        DB::transaction(function () use ($request, $bankBalance, $user) {

            $withdraw = BankWithdraw::create([
                'bank_balance_id' => $bankBalance->id,
                'user_id'         => $user->id,
                'withdraw_date'   => $request->withdraw_date,
                'amount'          => $request->amount,
                'withdraw_method' => $request->withdraw_method,
                'reference_no'    => $request->reference_no,
                'note'            => $request->note,
            ]);

            // Reduce bank balance
            $bankBalance->decrement('balance', $withdraw->amount);

            activity()
                ->causedBy($user)
                ->performedOn($withdraw)
                ->withProperties([
                    'bank_balance_id' => $bankBalance->id,
                    'amount'          => $request->amount,
                    'withdraw_method' => $request->withdraw_method,
                    'reference_no'    => $request->reference_no,
                ])
                ->log('Bank Withdrawal Created');
        });

        return redirect()
            ->route('bank_withdraws.index')
            ->with('success', 'Withdrawal added successfully.');
    }

    public function show(BankWithdraw $bankWithdraw)
    {
        return view('backend.financial_management.bank_withdraw.show', compact('bankWithdraw'));
    }

    // Show edit form
    public function edit(BankWithdraw $bankWithdraw)
    {
        $users = User::all();

        $balances = BankBalance::with([
            'user.payments',
            'deposits',
            'withdraws',
        ])->get();

        $balancesData = $balances->map(function ($balance) {
            $originalBalance = $balance->balance;
            return [
                'id' => $balance->id,
                'user_id' => $balance->user_id,
                'original_balance' => $originalBalance,
            ];
        });

        return view(
            'backend.financial_management.bank_withdraw.edit',
            compact('bankWithdraw', 'users', 'balances', 'balancesData')
        );
    }

    // Update withdrawal
    public function update(Request $request, BankWithdraw $bankWithdraw)
    {
        $request->validate([
            'bank_balance_id' => 'required|exists:bank_balances,id',
            'withdraw_date'   => 'required|date',
            'amount'          => 'required|numeric|min:1',
            'withdraw_method' => 'required|string',
        ]);

        $oldAmount = $bankWithdraw->amount;
        $oldBankId = $bankWithdraw->bank_balance_id;

        $newAmount = $request->amount;
        $newBankId = $request->bank_balance_id;

        DB::transaction(function () use (
            $bankWithdraw,
            $request,
            $oldAmount,
            $oldBankId,
            $newAmount,
            $newBankId
        ) {

            // If bank changed
            if ($oldBankId != $newBankId) {

                // Return old amount to old bank
                $oldBank = BankBalance::findOrFail($oldBankId);
                $oldBank->increment('balance', $oldAmount);

                // Deduct new amount from new bank
                $newBank = BankBalance::findOrFail($newBankId);

                if ($newAmount > $newBank->balance) {
                    throw new \Exception('Withdrawal exceeds new bank balance.');
                }

                $newBank->decrement('balance', $newAmount);
            } else {
                // Same bank — adjust difference
                $bank = BankBalance::findOrFail($newBankId);

                $difference = $newAmount - $oldAmount;

                if ($difference > 0 && $difference > $bank->balance) {
                    throw new \Exception('Withdrawal exceeds bank balance.');
                }

                $bank->decrement('balance', $difference);
            }

            // Update withdraw record
            $bankWithdraw->update([
                'bank_balance_id' => $newBankId,
                'withdraw_date'   => $request->withdraw_date,
                'amount'          => $newAmount,
                'withdraw_method' => $request->withdraw_method,
                'reference_no'    => $request->reference_no,
                'note'            => $request->note,
            ]);

            // 🔥 Activity Log
            activity()
                ->causedBy(auth()->user())
                ->performedOn($bankWithdraw)
                ->withProperties([
                    'old_bank_balance_id' => $oldBankId,
                    'new_bank_balance_id' => $newBankId,
                    'old_amount'          => $oldAmount,
                    'new_amount'          => $newAmount,
                    'withdraw_method'     => $request->withdraw_method,
                    'reference_no'        => $request->reference_no,
                ])
                ->log('Bank Withdrawal Updated');
        });

        return redirect()
            ->route('bank_withdraws.index')
            ->with('success', 'Withdrawal updated successfully.');
    }

    // Delete withdrawal
    public function destroy(BankWithdraw $bankWithdraw)
    {
        $bankBalance = BankBalance::findOrFail($bankWithdraw->bank_balance_id);
        $bankBalance->increment('balance', $bankWithdraw->amount);

        $bankWithdraw->delete();
        return redirect()->route('bank_withdraws.index')->with('success', 'Withdrawal deleted successfully.');
    }


    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;

        if (!$ids) {
            return response()->json([
                'success' => false
            ]);
        }

        BankWithdraw::whereIn('id', $ids)->delete();

        return response()->json([
            'success' => true
        ]);
    }
}
