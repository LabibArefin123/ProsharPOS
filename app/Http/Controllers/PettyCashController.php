<?php

namespace App\Http\Controllers;

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

        return view('transaction_management.petty_cash.index', compact('petty_cashes'));
    }

    public function create()
    {
        return view('transaction_management.petty_cash.create', [
            'users'         => User::all(),
            'customers'     => Customer::all(),
            'suppliers'     => Supplier::orderBy('name', 'asc')->get(),
            'categories'     => Category::orderBy('name', 'asc')->get(),
            'products'     => Product::orderBy('name', 'asc')->get(),
            'bank_balances' => BankBalance::all(),
        ]);
    }

    public function store(Request $request)
    {
        // ============================================================
        // START OF VALIDATION
        // ============================================================
        $validated = $request->validate([
            'reference_no'      => 'nullable|string|max:191',
            'type'              => 'required|in:receive,expense', // receive adds money, expense deducts
            'reference_type'    => 'nullable|string|max:100',
            'amount'            => 'required|numeric|min:0',
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
            'status'            => 'required|string', // pending OR approved
            'user_id'           => 'required|exists:users,id',
        ]);
        // ============================================================
        // END OF VALIDATION
        // ============================================================


        // ============================================================
        // START OF SANITIZING & PREPARING DATA
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
        // END OF SANITIZING & PREPARING DATA
        // ============================================================


        // ============================================================
        // START OF ATTACHMENT HANDLING
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
        // END OF ATTACHMENT HANDLING
        // ============================================================


        // ============================================================
        // START OF DATABASE TRANSACTION
        // ============================================================
        DB::beginTransaction();

        try {

            // Create petty cash record
            $petty = PettyCash::create($data);


            // ============================================================
            // START OF BANK BALANCE UPDATE
            // IMPORTANT RULE:
            // If STATUS = "pending" → DO NOT update bank balance
            // If STATUS = "approved" → UPDATE bank balance
            // ============================================================
            if (
                !empty($data['bank_balance_id']) &&
                isset($data['status']) &&
                strtolower($data['status']) === 'approved'
            ) {
                // Load bank record
                $bank = BankBalance::find($data['bank_balance_id']);

                if ($bank) {

                    // ----------- Update BDT amount -----------
                    if (
                        !empty($data['amount']) &&
                        (empty($data['currency']) || strtoupper($data['currency']) === 'BDT')
                    ) {
                        if ($data['type'] === 'expense') {
                            $bank->balance -= $data['amount']; // deduct
                        } else {
                            $bank->balance += $data['amount']; // add
                        }
                    }

                    // ----------- Update USD amount -----------
                    if (!empty($data['amount_in_dollar'])) {
                        if ($data['type'] === 'expense') {
                            $bank->balance_in_dollars -= $data['amount_in_dollar'];
                        } else {
                            $bank->balance_in_dollars += $data['amount_in_dollar'];
                        }
                    }

                    // Save updated bank
                    $bank->save();
                }
            }
            // ============================================================
            // END OF BANK BALANCE UPDATE
            // ============================================================


            DB::commit();
        } catch (\Throwable $e) {

            DB::rollBack();

            // Delete uploaded file on failure
            if (
                !empty($data['attachment']) &&
                file_exists(public_path('uploads/petty_cash/' . $data['attachment']))
            ) {
                @unlink(public_path('uploads/petty_cash/' . $data['attachment']));
            }

            return back()->withInput()->with('error', 'Failed to save petty cash: ' . $e->getMessage());
        }
        // ============================================================
        // END OF DATABASE TRANSACTION
        // ============================================================


        // ============================================================
        // RETURN SUCCESS
        // ============================================================
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

        return view('transaction_management.petty_cash.show', compact('petty_cash'));
    }


    public function edit($id)
    {
        return view('transaction_management.petty_cash.edit', [
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
        // START OF FETCHING OLD RECORD
        // ============================================================
        $petty_cash = PettyCash::findOrFail($id);
        $old_status = strtolower($petty_cash->status);
        $old_type = strtolower($petty_cash->type);
        $old_amount_bdt = $petty_cash->amount;
        $old_amount_usd = $petty_cash->amount_in_dollar;
        $old_bank_id = $petty_cash->bank_balance_id;
        // ============================================================
        // END OF FETCHING OLD RECORD
        // ============================================================


        // ============================================================
        // START OF VALIDATION
        // ============================================================
        $validated = $request->validate([
            'user_id'           => 'required|exists:users,id',
            'bank_balance_id'   => 'required|exists:bank_balances,id',
            'supplier_id'       => 'nullable|exists:suppliers,id',
            'customer_id'       => 'nullable|exists:customers,id',
            'category_id'       => 'nullable|exists:categories,id',
            'product_id'       => 'nullable|exists:products,id',
            'reference_no'      => 'nullable|string|max:191',
            'type'              => 'required|in:receive,expense',
            'reference_type'    => 'nullable|string|max:100',
            'amount'            => 'required|numeric|min:0', 
            'amount_in_dollar'  => 'nullable|numeric|min:0',  
            'exchange_rate'     => 'nullable|numeric|min:0', 
            'currency'          => 'nullable|string|max:10',
            'payment_method'    => 'required|string|max:50',
            'note'              => 'nullable|string', 
            'attachment'        => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120', 
            'status'            => 'required|string',
        ]);
        // ============================================================
        // END OF VALIDATION
        // ============================================================


        // ============================================================
        // START OF SANITIZING & PREPARING DATA
        // ============================================================
        $data = $request->only([
            'bank_balance_id',
            'supplier_id',
            'customer_id',
            'user_id',
            'reference_no',
            'type',
            'reference_type',
            'item_name',
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
        // END OF SANITIZING & PREPARING DATA
        // ============================================================


        // ============================================================
        // START OF ATTACHMENT HANDLING
        // ============================================================
        if ($request->hasFile('attachment')) {

            $file = $request->file('attachment');
            $ext = $file->getClientOriginalExtension();
            $filename = 'petty_cash_' . date('Ymd_His') . '.' . $ext;

            $destination = public_path('uploads/petty_cash/');
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }

            // Delete old file
            if ($petty_cash->attachment && file_exists($destination . $petty_cash->attachment)) {
                @unlink($destination . $petty_cash->attachment);
            }

            $file->move($destination, $filename);
            $data['attachment'] = $filename;
        }
        // ============================================================
        // END OF ATTACHMENT HANDLING
        // ============================================================


        // ============================================================
        // START OF TRANSACTION
        // ============================================================
        DB::beginTransaction();

        try {

            // Update petty cash first
            $petty_cash->update($data);

            // ============================================================
            // START OF BANK BALANCE LOGIC
            // RULES:
            // 1) If NEW STATUS = pending → no update
            // 2) If OLD STATUS = pending AND NEW STATUS = approved → apply new amounts
            // 3) If OLD STATUS = approved AND NEW STATUS = approved → rollback old + apply new
            // 4) If OLD STATUS = approved AND NEW STATUS = pending → rollback old impact
            // ============================================================

            $bank = BankBalance::find($data['bank_balance_id']);
            if ($bank) {

                // -------- CASE A: OLD approved → rollback old amounts --------
                if ($old_status === 'approved') {

                    // rollback BDT
                    if ($old_amount_bdt > 0 && (empty($petty_cash->currency) || strtoupper($petty_cash->currency) === 'BDT')) {
                        if ($old_type === 'expense') {
                            $bank->balance += $old_amount_bdt;
                        } else {
                            $bank->balance -= $old_amount_bdt;
                        }
                    }

                    // rollback USD
                    if ($old_amount_usd > 0) {
                        if ($old_type === 'expense') {
                            $bank->balance_in_dollars += $old_amount_usd;
                        } else {
                            $bank->balance_in_dollars -= $old_amount_usd;
                        }
                    }
                }

                // -------- CASE B: NEW status = approved → apply NEW amounts --------
                if ($new_status === 'approved') {

                    // Apply BDT
                    if (
                        !empty($data['amount']) &&
                        (empty($data['currency']) || strtoupper($data['currency']) === 'BDT')
                    ) {
                        if ($new_type === 'expense') {
                            $bank->balance -= $data['amount'];
                        } else {
                            $bank->balance += $data['amount'];
                        }
                    }

                    // Apply USD
                    if (!empty($data['amount_in_dollar'])) {
                        if ($new_type === 'expense') {
                            $bank->balance_in_dollars -= $data['amount_in_dollar'];
                        } else {
                            $bank->balance_in_dollars += $data['amount_in_dollar'];
                        }
                    }
                }

                // -------- CASE C: NEW status = pending → do nothing more --------

                // Save bank record
                $bank->save();
            }

            // ============================================================
            // END OF BANK BALANCE LOGIC
            // ============================================================

            DB::commit();
        } catch (\Throwable $e) {

            DB::rollBack();

            // Delete uploaded file on error
            if (
                !empty($data['attachment']) &&
                file_exists(public_path('uploads/petty_cash/' . $data['attachment']))
            ) {
                @unlink(public_path('uploads/petty_cash/' . $data['attachment']));
            }

            return back()->withInput()->with('error', 'Failed to update petty cash: ' . $e->getMessage());
        }

        // ============================================================
        // END OF TRANSACTION
        // ============================================================


        return redirect()->route('petty_cashes.index')->with('success', 'Petty Cash updated successfully.');
    }

    public function destroy($id)
    {
        PettyCash::findOrFail($id)->delete();
        return redirect()->route('petty_cashes.index')->with('success', 'Petty Cash deleted successfully.');
    }
}
