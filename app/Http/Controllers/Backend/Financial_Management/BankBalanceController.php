<?php

namespace App\Http\Controllers\Backend\Financial_Management;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
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
        $user = auth()->user();

        $balancesQuery = BankBalance::with([
            'user.payments',
            'deposits',
            'withdraws',
        ]);

        // If NOT admin → only show own bank balance
        if (!$user->hasRole('admin')) {
            $balancesQuery->where('user_id', $user->id);
        }

        $balances = $balancesQuery->get();

        $balances->each(function ($balance) {

            // Original DB balance (never change this)
            $balance->original_balance = $balance->balance;

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
            'user_id'             => 'required|exists:users,id',
            'balance'             => 'required|numeric|min:0',
            'balance_in_dollars'  => 'nullable|numeric|min:0',
        ]);

        DB::transaction(function () use ($request) {

            // Create bank balance
            $bankBalance = BankBalance::create([
                'user_id'            => $request->user_id,
                'balance'            => $request->balance,
                'balance_in_dollars' => $request->balance_in_dollars ?? 0,
            ]);

            // 🔥 Activity Log
            activity()
                ->causedBy(auth()->user())
                ->performedOn($bankBalance)
                ->withProperties([
                    'user_id'            => $request->user_id,
                    'balance_bdt'        => $request->balance,
                    'balance_usd'        => $request->balance_in_dollars ?? 0,
                ])
                ->log('Bank Balance Created');
        });

        return redirect()
            ->route('bank_balances.index')
            ->with('success', 'Balance added successfully.');
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
            'user_id'             => 'required|exists:users,id',
            'balance'             => 'required|numeric|min:0',
            'balance_in_dollars'  => 'nullable|numeric|min:0',
        ]);

        DB::transaction(function () use ($request, $bank_balance) {

            // Store old values for activity log
            $oldData = [
                'user_id'            => $bank_balance->user_id,
                'balance_bdt'        => $bank_balance->balance,
                'balance_usd'        => $bank_balance->balance_in_dollars,
            ];

            // Update bank balance
            $bank_balance->update([
                'user_id'            => $request->user_id,
                'balance'            => $request->balance,
                'balance_in_dollars' => $request->balance_in_dollars ?? 0,
            ]);

            // 🔥 Activity Log
            activity()
                ->causedBy(auth()->user())
                ->performedOn($bank_balance)
                ->withProperties([
                    'old' => $oldData,
                    'new' => [
                        'user_id'            => $request->user_id,
                        'balance_bdt'        => $request->balance,
                        'balance_usd'        => $request->balance_in_dollars ?? 0,
                    ]
                ])
                ->log('Bank Balance Updated');
        });

        return redirect()
            ->route('bank_balances.index')
            ->with('success', 'Balance updated successfully.');
    }

    public function destroy(BankBalance $bank_balance)
    {
        $bank_balance->delete();
        return redirect()->route('bank_balances.index')->with('success', 'Balance deleted successfully.');
    }
}
