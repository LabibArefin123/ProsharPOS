<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PettyCash;
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
            'bank_balances' => BankBalance::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'reference_no'      => 'nullable|string|max:191',
            'type'              => 'required|in:receive,expense',
            'reference_type'    => 'nullable|string|max:100',
            'item_name'         => 'required|string|max:255',
            'amount'            => 'required|numeric|min:0',
            'amount_in_dollar'  => 'nullable|numeric|min:0',
            'exchange_rate'     => 'nullable|numeric|min:0',
            'currency'          => 'nullable|string|max:10',
            'payment_method'    => 'required|string|max:50',
            'bank_balance_id'   => 'required|exists:bank_balances,id',
            'supplier_id'       => 'nullable|exists:suppliers,id',
            'customer_id'       => 'nullable|exists:customers,id',
            'category'          => 'required|string|max:100',
            'note'              => 'nullable|string',
            'attachment'        => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'status'            => 'required|string',
            'user_id'           => 'required|exists:users,id',
        ]);

        // Use only allowed/fillable fields to avoid mass-assignment surprises
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

        // If no reference_no provided, generate one (optional but handy)
        if (empty($data['reference_no'])) {
            $data['reference_no'] = 'PC-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4));
        }

        // Attachment handling: save as petty_cash_YYYYmmdd_His.ext
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $ext = $file->getClientOriginalExtension();
            $filename = 'petty_cash_' . date('Ymd_His') . '.' . $ext;
            // ensure uploads directory exists (php will create folder on move if not exists in many setups, but safe)
            $destination = public_path('uploads/petty_cash/');
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }
            $file->move($destination, $filename);
            $data['attachment'] = $filename;
        }

        // If status not provided, default to 'approved' (you can change to 'pending' if you prefer)
        if (empty($data['status'])) {
            $data['status'] = 'approved';
        }

        DB::beginTransaction();
        try {
            $petty = PettyCash::create($data);
            // Optional: update bank balance record if linked
            if (!empty($data['bank_balance_id'])) {
                $bank = BankBalance::find($data['bank_balance_id']);
                if ($bank) {
                    // Update BDT balance if BDT amount provided (or currency is BDT)
                    // Use 'amount' for BDT and 'amount_in_dollar' for USD
                    if (!empty($data['amount']) && (empty($data['currency']) || strtoupper($data['currency']) === 'BDT')) {
                        if ($data['type'] === 'expense') {
                            $bank->balance = $bank->balance - $data['amount'];
                        } else { // receive
                            $bank->balance = $bank->balance + $data['amount'];
                        }
                    }

                    if (!empty($data['amount_in_dollar'])) {
                        if ($data['type'] === 'expense') {
                            $bank->balance_in_dollars = $bank->balance_in_dollars - $data['amount_in_dollar'];
                        } else {
                            $bank->balance_in_dollars = $bank->balance_in_dollars + $data['amount_in_dollar'];
                        }
                    }

                    $bank->save();
                }
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            // If file was saved, consider deleting it on failure
            if (!empty($data['attachment']) && file_exists(public_path('uploads/petty_cash/' . $data['attachment']))) {
                @unlink(public_path('uploads/petty_cash/' . $data['attachment']));
            }
            return back()->withInput()->with('error', 'Failed to save petty cash: ' . $e->getMessage());
        }

        return redirect()->route('petty_cashes.index')->with('success', 'Petty Cash created successfully.');
    }

    public function edit($id)
    {
        return view('transaction_management.petty_cash.edit', [
            'petty_cash'    => PettyCash::findOrFail($id),
            'users'         => User::all(),
            'customers'     => Customer::all(),
            'suppliers'     => Supplier::all(),
            'bank_balances' => BankBalance::all(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $petty_cash = PettyCash::findOrFail($id);

        // Validate all necessary fields
        $validated = $request->validate([
            'reference_no'      => 'nullable|string|max:191',
            'type'              => 'required|in:receive,expense',
            'reference_type'    => 'nullable|string|max:100',
            'item_name'         => 'required|string|max:255',
            'amount'            => 'required|numeric|min:0',
            'amount_in_dollar'  => 'nullable|numeric|min:0',
            'exchange_rate'     => 'nullable|numeric|min:0',
            'currency'          => 'nullable|string|max:10',
            'payment_method'    => 'required|string|max:50',
            'bank_balance_id'   => 'required|exists:bank_balances,id',
            'supplier_id'       => 'nullable|exists:suppliers,id',
            'customer_id'       => 'nullable|exists:customers,id',
            'category'          => 'required|string|max:100',
            'note'              => 'nullable|string',
            'attachment'        => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'status'            => 'required|string',
            'user_id'           => 'required|exists:users,id',
        ]);

        // Only fillable fields
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

        // Generate reference_no if empty
        if (empty($data['reference_no'])) {
            $data['reference_no'] = 'PC-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4));
        }

        // Handle attachment file
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $ext = $file->getClientOriginalExtension();
            $filename = 'petty_cash_' . date('Ymd_His') . '.' . $ext;

            $destination = public_path('uploads/petty_cash/');
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }

            // Delete old attachment if exists
            if ($petty_cash->attachment && file_exists($destination . $petty_cash->attachment)) {
                @unlink($destination . $petty_cash->attachment);
            }

            $file->move($destination, $filename);
            $data['attachment'] = $filename;
        }

        DB::beginTransaction();
        try {
            // Update petty cash
            $petty_cash->update($data);

            // Optional: update bank balance
            if (!empty($data['bank_balance_id'])) {
                $bank = BankBalance::find($data['bank_balance_id']);
                if ($bank) {
                    // Recalculate BDT balance
                    if (!empty($data['amount']) && (empty($data['currency']) || strtoupper($data['currency']) === 'BDT')) {
                        // Subtract old amount first
                        if ($petty_cash->type === 'expense') {
                            $bank->balance += $petty_cash->amount; // rollback old
                        } else {
                            $bank->balance -= $petty_cash->amount;
                        }

                        // Apply new amount
                        if ($data['type'] === 'expense') {
                            $bank->balance -= $data['amount'];
                        } else {
                            $bank->balance += $data['amount'];
                        }
                    }

                    // Recalculate USD balance
                    if (!empty($data['amount_in_dollar'])) {
                        if ($petty_cash->type === 'expense') {
                            $bank->balance_in_dollars += $petty_cash->amount_in_dollar; // rollback old
                        } else {
                            $bank->balance_in_dollars -= $petty_cash->amount_in_dollar;
                        }

                        if ($data['type'] === 'expense') {
                            $bank->balance_in_dollars -= $data['amount_in_dollar'];
                        } else {
                            $bank->balance_in_dollars += $data['amount_in_dollar'];
                        }
                    }

                    $bank->save();
                }
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            // Delete new attachment if saved
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
