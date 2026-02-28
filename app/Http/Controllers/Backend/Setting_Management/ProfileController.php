<?php

namespace App\Http\Controllers\Backend\Setting_Management;

use App\Http\Controllers\Controller;
use App\Models\BankBalance;
use App\Models\BankDeposit;
use App\Models\BankWithdraw;
use App\Models\Payment;
use App\Models\Purchase;
use App\Models\PurchaseReturn;
use App\Models\SupplierPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function user_profile_show()
    {
        $user = Auth::user();

        // Get bank balance for current user, if not exists show 0
        $bankBalance = BankBalance::where('user_id', $user->id)->first();
        if (!$bankBalance) {
            $bankBalance = (object)[
                'balance' => 0,
                'balance_in_dollars' => 0,
            ];
        }

        // Deposits
        $deposits = BankDeposit::where('user_id', $user->id)->get()->map(function ($d) {
            return (object)[
                'type' => 'deposit',
                'date' => $d->deposit_date,
                'created_at' => $d->created_at,
                'amount' => (float)$d->amount,
                'description' => $d->reference_no,
            ];
        });

        // Withdrawals
        $withdraws = BankWithdraw::where('user_id', $user->id)->get()->map(function ($w) {
            return (object)[
                'type' => 'withdraw',
                'date' => $w->withdraw_date,
                'created_at' => $w->created_at,
                'amount' => (float)$w->amount,
                'description' => $w->reference_no,
            ];
        });

        // Customer Payments
        $payments = Payment::where('paid_by', $user->id)->get()->map(function ($p) {
            return (object)[
                'type' => 'payment',
                'date' => $p->created_at,
                'created_at' => $p->created_at,
                'amount' => (float)$p->paid_amount,
                'description' => $p->invoice->invoice_id ?? 'Payment',
            ];
        });

        // Purchases (user as supplier)
        $purchases = Purchase::where('supplier_id', $user->id)->get()->map(function ($pu) {
            return (object)[
                'type' => 'purchase',
                'date' => $pu->created_at,
                'created_at' => $pu->created_at,
                'amount' => (float)$pu->total_amount,
                'description' => $pu->reference_no ?? 'Purchase',
            ];
        });

        // Purchase Returns
        $returns = PurchaseReturn::where('supplier_id', $user->id)->get()->map(function ($r) {
            return (object)[
                'type' => 'purchase_return',
                'date' => $r->return_date,
                'created_at' => $r->created_at,
                'amount' => (float)$r->total_amount,
                'description' => $r->reference_no ?? 'Purchase Return',
            ];
        });

        // Supplier Payments
        $supplierPayments = SupplierPayment::where('supplier_id', $user->id)->get()->map(function ($sp) {
            return (object)[
                'type' => 'supplier_payment',
                'date' => $sp->payment_date,
                'created_at' => $sp->created_at,
                'amount' => (float)$sp->amount,
                'description' => $sp->purchase->reference_no ?? 'Supplier Payment',
            ];
        });

        // Merge all transactions and sort descending
        $transactions = collect()
            ->merge($deposits)
            ->merge($withdraws)
            ->merge($payments)
            ->merge($purchases)
            ->merge($returns)
            ->merge($supplierPayments)
            ->sortByDesc('created_at')
            ->take(5); // last 5 transactions

        return view('backend.setting_management.profile_page.show', compact('user', 'bankBalance', 'transactions'));
    }
    /**
     * Display the user's profile form.
     */


    public function user_profile_edit()
    {
        $user = Auth::user();
        return view('backend.setting_management.profile_page.edit', compact('user'));
    }

    public function user_profile_update(Request $request)
    {
        $user = Auth::user();

        // Validate the incoming request
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:15',
        ]);

        // Update user fields
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->phone = $request->phone;

        // Profile picture handling
        if ($request->hasFile('profile_picture')) {
            $image = $request->file('profile_picture');
            $imagePath = $image->store('profile_pictures', 'public');

            // Delete old picture if exists
            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }

            $user->profile_picture = $imagePath;
        }

        $user->save();

        return redirect()->route('profile')->with('success', 'Profile updated successfully.');
    }
}
