<?php

namespace App\Http\Controllers\Backend\Transaction_Management;

use App\Http\Controllers\Controller;
use App\Models\PettyCash;
use App\Models\Product;
use App\Models\Category;
use App\Models\BankBalance;
use App\Models\Supplier;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class PettyCashController extends Controller
{
    public function index()
    {
        $petty_cashes = PettyCash::with(['bankBalance', 'supplier', 'customer'])
            ->orderBy('id', 'asc')->get();

        return view('backend.transaction_management.petty_cash.index', compact('petty_cashes'));
    }

    public function create()
    {
        // Default exchange rate (USD -> BDT)
        $defaultExchangeRate = 108.50; // you can update this manually

        return view('backend.transaction_management.petty_cash.create', [
            'users'         => User::all(),
            'customers'     => Customer::all(),
            'suppliers'     => Supplier::orderBy('name', 'asc')->get(),
            'categories'    => Category::orderBy('name', 'asc')->get(),
            'products'      => Product::orderBy('name', 'asc')->get(),
            'bank_balances' => BankBalance::all(),
            'exchangeRate'  => $defaultExchangeRate, // Pass to Blade
        ]);
    }

    public function store(Request $request)
    {
        // ============================================================
        // VALIDATION
        // ============================================================
        $validated = $request->validate([
            'reference_no'      => 'nullable|string|max:191',
            'type'              => 'required|in:receive,expense',
            'reference_type'    => 'nullable|string|max:100',
            'amount'            => 'nullable|numeric|min:0',
            'amount_in_dollar'  => 'nullable|numeric|min:0',
            'exchange_rate'     => 'nullable|numeric|min:0',
            'currency'          => 'nullable|string|max:10',
            'payment_method'    => 'required|string|max:50',
            'bank_balance_id'   => 'required|exists:bank_balances,id',
            'supplier_id'       => 'nullable|exists:suppliers,id',
            'customer_id'       => 'nullable|exists:customers,id',
            'category_id'       => 'nullable|exists:categories,id',
            'product_id'        => 'nullable|exists:products,id',
            'note'              => 'nullable|string',
            'attachment'        => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'status'            => 'required|string',
            'user_id'           => 'required|exists:users,id',
        ]);

        // ============================================================
        // SANITIZE & PREPARE DATA
        // ============================================================
        $data = $request->only([
            'bank_balance_id',
            'supplier_id',
            'customer_id',
            'category_id',
            'product_id',
            'user_id',
            'reference_no',
            'type',
            'reference_type',
            'amount',
            'amount_in_dollar',
            'exchange_rate',
            'currency',
            'payment_method',
            'note',
            'status',
        ]);

        // Auto-generate reference_no if missing
        if (empty($data['reference_no'])) {
            $data['reference_no'] = 'PC-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4));
        }

        // ============================================================
        // AUTO-CALCULATE AMOUNT FIELDS
        // ============================================================
        $exchangeRate = $data['exchange_rate'] ?? 108.50; // fallback

        // If user entered only BDT
        if (!empty($data['amount']) && (empty($data['amount_in_dollar']) || $data['amount_in_dollar'] == 0)) {
            $data['amount_in_dollar'] = round($data['amount'] / $exchangeRate, 2);
        }

        // If user entered only USD
        if (!empty($data['amount_in_dollar']) && (empty($data['amount']) || $data['amount'] == 0)) {
            $data['amount'] = round($data['amount_in_dollar'] * $exchangeRate, 2);
        }

        // ============================================================
        // HANDLE ATTACHMENT
        // ============================================================
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $ext = $file->getClientOriginalExtension();
            $filename = 'petty_cash_' . date('Ymd_His') . '.' . $ext;

            $destination = public_path('uploads/petty_cash/');
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }

            $file->move($destination, $filename);
            $data['attachment'] = $filename;
        }

        // ============================================================
        // DATABASE TRANSACTION
        // ============================================================
        DB::beginTransaction();

        try {
            $petty = PettyCash::create($data);

            // Update bank balances if approved
            if (!empty($data['bank_balance_id']) && strtolower($data['status']) === 'approved') {
                $bank = BankBalance::find($data['bank_balance_id']);
                if ($bank) {
                    // BDT
                    if (!empty($data['amount']) && (empty($data['currency']) || strtoupper($data['currency']) === 'BDT')) {
                        $bank->balance += $data['type'] === 'expense' ? -$data['amount'] : $data['amount'];
                    }

                    // USD
                    if (!empty($data['amount_in_dollar'])) {
                        $bank->balance_in_dollars += $data['type'] === 'expense' ? -$data['amount_in_dollar'] : $data['amount_in_dollar'];
                    }

                    $bank->save();
                }
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();

            if (!empty($data['attachment']) && file_exists(public_path('uploads/petty_cash/' . $data['attachment']))) {
                @unlink(public_path('uploads/petty_cash/' . $data['attachment']));
            }

            return back()->withInput()->with('error', 'Failed to save petty cash: ' . $e->getMessage());
        }

        return redirect()->route('petty_cashes.index')
            ->with('success', 'Petty Cash created successfully.');
    }

    public function show($id)
    {
        $petty_cash = PettyCash::with([
            'product',
            'bankBalance.user',
            'supplier',
            'customer',
            'category',
            'user'
        ])->findOrFail($id);

        return view('backend.transaction_management.petty_cash.show', compact('petty_cash'));
    }


    public function edit($id)
    {
        return view('backend.transaction_management.petty_cash.edit', [
            'petty_cash'    => PettyCash::findOrFail($id),
            'users'         => User::all(),
            'customers'     => Customer::all(),
            'suppliers'     => Supplier::all(),
            'bank_balances' => BankBalance::all(),
            'categories'     => Category::orderBy('name', 'asc')->get(),
            'products'     => Product::orderBy('name', 'asc')->get(),
        ]);
    }
    public function update(Request $request, $id)
    {
        // ============================================================
        // FETCH OLD RECORD
        // ============================================================
        $petty_cash = PettyCash::findOrFail($id);
        $old_status = strtolower($petty_cash->status);
        $old_type = strtolower($petty_cash->type);
        $old_amount_bdt = $petty_cash->amount;
        $old_amount_usd = $petty_cash->amount_in_dollar;
        $old_bank_id = $petty_cash->bank_balance_id;

        // ============================================================
        // VALIDATION
        // ============================================================
        $validated = $request->validate([
            'user_id'           => 'required|exists:users,id',
            'bank_balance_id'   => 'required|exists:bank_balances,id',
            'supplier_id'       => 'nullable|exists:suppliers,id',
            'customer_id'       => 'nullable|exists:customers,id',
            'category_id'       => 'nullable|exists:categories,id',
            'product_id'        => 'nullable|exists:products,id',
            'reference_no'      => 'nullable|string|max:191',
            'type'              => 'required|in:receive,expense',
            'reference_type'    => 'nullable|string|max:100',
            'amount'            => 'nullable|numeric|min:0',
            'amount_in_dollar'  => 'nullable|numeric|min:0',
            'exchange_rate'     => 'nullable|numeric|min:0',
            'currency'          => 'nullable|string|max:10',
            'payment_method'    => 'required|string|max:50',
            'note'              => 'nullable|string',
            'attachment'        => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'status'            => 'required|string',
        ]);

        // ============================================================
        // SANITIZE & PREPARE DATA
        // ============================================================
        $data = $request->only([
            'bank_balance_id',
            'supplier_id',
            'customer_id',
            'user_id',
            'reference_no',
            'type',
            'reference_type',
            'amount',
            'amount_in_dollar',
            'exchange_rate',
            'currency',
            'payment_method',
            'category',
            'note',
            'status',
        ]);

        if (empty($data['reference_no'])) {
            $data['reference_no'] = 'PC-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4));
        }

        $new_status = strtolower($data['status']);
        $new_type = strtolower($data['type']);

        // ============================================================
        // AUTO-CALCULATE AMOUNTS
        // ============================================================
        $exchangeRate = $data['exchange_rate'] ?? 108.50;

        if (!empty($data['amount']) && (empty($data['amount_in_dollar']) || $data['amount_in_dollar'] == 0)) {
            $data['amount_in_dollar'] = round($data['amount'] / $exchangeRate, 2);
        }

        if (!empty($data['amount_in_dollar']) && (empty($data['amount']) || $data['amount'] == 0)) {
            $data['amount'] = round($data['amount_in_dollar'] * $exchangeRate, 2);
        }

        // ============================================================
        // ATTACHMENT HANDLING
        // ============================================================
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $ext = $file->getClientOriginalExtension();
            $filename = 'petty_cash_' . date('Ymd_His') . '.' . $ext;

            $destination = public_path('uploads/petty_cash/');
            if (!file_exists($destination)) mkdir($destination, 0755, true);

            // Delete old file
            if ($petty_cash->attachment && file_exists($destination . $petty_cash->attachment)) {
                @unlink($destination . $petty_cash->attachment);
            }

            $file->move($destination, $filename);
            $data['attachment'] = $filename;
        }

        // ============================================================
        // DATABASE TRANSACTION
        // ============================================================
        DB::beginTransaction();

        try {
            // Update petty cash
            $petty_cash->update($data);

            // Update bank balance logic
            $bank = BankBalance::find($data['bank_balance_id']);
            if ($bank) {
                // -------- ROLLBACK OLD AMOUNTS IF OLD STATUS = approved --------
                if ($old_status === 'approved') {
                    if ($old_amount_bdt > 0 && (empty($petty_cash->currency) || strtoupper($petty_cash->currency) === 'BDT')) {
                        $bank->balance += ($old_type === 'expense') ? $old_amount_bdt : -$old_amount_bdt;
                    }

                    if ($old_amount_usd > 0) {
                        $bank->balance_in_dollars += ($old_type === 'expense') ? $old_amount_usd : -$old_amount_usd;
                    }
                }

                // -------- APPLY NEW AMOUNTS IF NEW STATUS = approved --------
                if ($new_status === 'approved') {
                    if (!empty($data['amount']) && (empty($data['currency']) || strtoupper($data['currency']) === 'BDT')) {
                        $bank->balance += ($new_type === 'expense') ? -$data['amount'] : $data['amount'];
                    }

                    if (!empty($data['amount_in_dollar'])) {
                        $bank->balance_in_dollars += ($new_type === 'expense') ? -$data['amount_in_dollar'] : $data['amount_in_dollar'];
                    }
                }

                $bank->save();
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();

            if (!empty($data['attachment']) && file_exists(public_path('uploads/petty_cash/' . $data['attachment']))) {
                @unlink(public_path('uploads/petty_cash/' . $data['attachment']));
            }

            return back()->withInput()->with('error', 'Failed to update petty cash: ' . $e->getMessage());
        }

        return redirect()->route('petty_cashes.index')->with('success', 'Petty Cash updated successfully.');
    }

    public function destroy($id)
    {
        PettyCash::findOrFail($id)->delete();
        return redirect()->route('petty_cashes.index')->with('success', 'Petty Cash deleted successfully.');
    }
}
