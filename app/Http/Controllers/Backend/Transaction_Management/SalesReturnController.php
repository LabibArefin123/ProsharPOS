<?php

namespace App\Http\Controllers\Backend\Transaction_Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BankBalance;
use App\Models\BankDeposit;
use App\Models\SalesReturn;
use App\Models\SalesReturnItem;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Branch;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SalesReturnController extends Controller
{
    public function index()
    {
        $returns = SalesReturn::with(['invoice', 'customer', 'branch'])
            ->orderBy('id', 'DESC')
            ->get();

        return view('backend.transaction_management.sales_returns.index', compact('returns'));
    }

    public function create()
    {
        // Get only PAID invoices (status = 1)
        $invoices = Invoice::with([
            'customer',
            'invoiceItems.product'
        ])->where('status', 1)->get();

        $customers = Customer::all();
        $branches  = Branch::all();

        return view('backend.transaction_management.sales_returns.create', compact(
            'invoices',
            'customers',
            'branches'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'invoice_id'   => 'required|exists:invoices,id',
            'customer_id'  => 'required|exists:customers,id',
            'branch_id'    => 'required|exists:branches,id',
            'return_date'  => 'required|date',
            'items'        => 'required|json',
            'refund_method' => 'nullable|string',
            'note'         => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {

            $invoice = Invoice::with('invoiceItems')
                ->where('id', $request->invoice_id)
                ->where('status', 1) // ✅ must be PAID
                ->firstOrFail();

            // Extra validation (customer match)
            if ($invoice->customer_id != $request->customer_id) {
                throw new \Exception('Invoice customer mismatch.');
            }

            $items = json_decode($request->items, true);

            if (empty($items)) {
                throw new \Exception('No products received.');
            }

            $returnNo = 'SR-' . now()->format('ymdHis') . rand(10, 99);
            $subTotal = 0;

            $salesReturn = SalesReturn::create([
                'return_no'     => $returnNo,
                'invoice_id'    => $invoice->id,
                'customer_id'   => $invoice->customer_id,
                'branch_id'     => $invoice->branch_id,
                'return_date'   => $request->return_date,
                'refund_method' => $request->refund_method,
                'note'          => $request->note,
                'created_by'    => Auth::id(),
            ]);

            foreach ($items as $item) {

                // Validate structure
                if (!isset($item['product_id'], $item['quantity'], $item['price'])) {
                    throw new \Exception('Invalid item data.');
                }

                // Validate quantity against invoice
                $invoiceItem = $invoice->invoiceItems
                    ->where('product_id', $item['product_id'])
                    ->first();

                if (!$invoiceItem) {
                    throw new \Exception('Product not found in invoice.');
                }

                if ($item['quantity'] > $invoiceItem->quantity) {
                    throw new \Exception('Return quantity exceeds sold quantity.');
                }

                $subtotal = $item['quantity'] * $item['price'];
                $subTotal += $subtotal;

                SalesReturnItem::create([
                    'sales_return_id' => $salesReturn->id,
                    'product_id'      => $item['product_id'],
                    'quantity'        => $item['quantity'],
                    'price'           => $item['price'],
                    'subtotal'        => $subtotal,
                ]);

                // Increase stock
                $product = Product::find($item['product_id']);
                if ($product && Schema::hasColumn('products', 'stock')) {
                    $product->increment('stock', $item['quantity']);
                }
            }

            $salesReturn->update([
                'sub_total'           => $subTotal,
                'total_return_amount' => $subTotal,
                'refund_amount'       => $subTotal,
            ]);

            // Adjust invoice if needed
            if ($request->refund_method === 'adjust_due') {

                $invoice->paid_amount -= $subTotal;
                $invoice->total -= $subTotal;
                $invoice->save();
            }

            if ($request->refund_method === 'cash') {

                // 1️⃣ Create negative payment record (refund)
                Payment::create([
                    'payment_id'   => 'RET-' . time(),
                    'invoice_id'   => $invoice->id,
                    'payment_name' => 'Sales Return Refund',
                    'paid_amount'  => -$subTotal,
                    'due_amount'   => 0,
                    'paid_by'      => Auth::id(),
                    'payment_type' => 'return',
                ]);

                // 2️⃣ Add money back to BankDeposit (Cash Account)
                $bank = BankBalance::where('branch_id', $invoice->branch_id)
                    ->where('type', 'cash') // or your condition
                    ->first();

                if (!$bank) {
                    throw new \Exception('Cash bank account not found.');
                }

                // Create deposit entry
                BankDeposit::create([
                    'bank_balance_id' => $bank->id,
                    'amount'          => $subTotal, // POSITIVE (money added back)
                    'amount_in_dollar' => 0,
                    'note'            => 'Sales Return Refund - ' . $returnNo,
                    'user_id'         => Auth::id(),
                ]);

                // 3️⃣ Update bank balance
                $bank->increment('balance', $subTotal);
            }

            DB::commit();

            return redirect()
                ->route('sales_returns.index')
                ->with('success', 'Sales Return created successfully!');
        } catch (\Exception $e) {

            DB::rollback();

            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    public function show($id)
    {
        $return = SalesReturn::with(['invoice', 'customer', 'branch', 'items.product'])
            ->findOrFail($id);

        return view('backend.transaction_management.sales_returns.show', compact('return'));
    }

    public function edit($id)
    {
        $salesReturn = SalesReturn::with(['items', 'invoice'])
            ->findOrFail($id);
        $customers = Customer::all();
        $branches = Branch::all();
        $invoices = Invoice::with([
            'customer',
            'invoiceItems.product'
        ])->where('status', 1)->get();
        return view(
            'backend.transaction_management.sales_returns.edit',
            compact('salesReturn', 'invoices', 'customers', 'branches')
        );
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'return_date'   => 'required|date',
            'items'         => 'required|json',
            'refund_method' => 'nullable|string',
            'note'          => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            $salesReturn = SalesReturn::with(['items', 'invoice'])->findOrFail($id);
            $invoice = $salesReturn->invoice;
            $oldSubTotal = $salesReturn->sub_total;

            /*
        ============================================
        STEP 1: REVERSE OLD EFFECTS
        ============================================
        */

            // 🔁 Reverse Stock
            foreach ($salesReturn->items as $oldItem) {
                $product = Product::find($oldItem->product_id);
                if ($product && Schema::hasColumn('products', 'stock')) {
                    $product->decrement('stock', $oldItem->quantity);
                }
            }

            // 🔁 Reverse Invoice Adjust
            if ($salesReturn->refund_method === 'adjust_due') {
                $invoice->paid_amount += $oldSubTotal;
                $invoice->total += $oldSubTotal;
                $invoice->save();
            }

            // 🔁 Reverse Cash Refund
            if ($salesReturn->refund_method === 'cash') {

                // Delete old payment
                Payment::where('invoice_id', $invoice->id)
                    ->where('payment_type', 'return')
                    ->where('paid_amount', -$oldSubTotal)
                    ->delete();

                // Reverse Bank Balance (simplified)
                $bank = BankBalance::first(); // Take first bank record
                if ($bank) {
                    $bank->decrement('balance', $oldSubTotal);
                }

                // Delete deposit entry
                BankDeposit::where('note', 'LIKE', '%Sales Return Refund - ' . $salesReturn->return_no . '%')
                    ->delete();
            }

            // Delete old items
            SalesReturnItem::where('sales_return_id', $salesReturn->id)->delete();

            /*
        ============================================
        STEP 2: APPLY NEW DATA
        ============================================
        */

            $items = json_decode($request->items, true);
            $subTotal = 0;

            foreach ($items as $item) {
                $subtotal = $item['quantity'] * $item['price'];
                $subTotal += $subtotal;

                SalesReturnItem::create([
                    'sales_return_id' => $salesReturn->id,
                    'product_id'      => $item['product_id'],
                    'quantity'        => $item['quantity'],
                    'price'           => $item['price'],
                    'subtotal'        => $subtotal,
                ]);

                // Increase stock again
                $product = Product::find($item['product_id']);
                if ($product && Schema::hasColumn('products', 'stock')) {
                    $product->increment('stock', $item['quantity']);
                }
            }

            // Update main return
            $salesReturn->update([
                'return_date'         => $request->return_date,
                'refund_method'       => $request->refund_method,
                'note'                => $request->note,
                'sub_total'           => $subTotal,
                'total_return_amount' => $subTotal,
                'refund_amount'       => $subTotal,
            ]);

            /*
        ============================================
        STEP 3: APPLY NEW REFUND METHOD
        ============================================
        */

            if ($request->refund_method === 'adjust_due') {
                $invoice->paid_amount -= $subTotal;
                $invoice->total -= $subTotal;
                $invoice->save();
            }

            if ($request->refund_method === 'cash') {

                Payment::create([
                    'payment_id'   => 'RET-' . time(),
                    'invoice_id'   => $invoice->id,
                    'payment_name' => 'Sales Return Refund (Updated)',
                    'paid_amount'  => -$subTotal,
                    'due_amount'   => 0,
                    'paid_by'      => Auth::id(),
                    'payment_type' => 'return',
                ]);

                // Adjust first bank account only
                $bank = BankBalance::first();
                if (!$bank) {
                    // create a default bank if none exists
                    $bank = BankBalance::create([
                        'user_id' => Auth::id(),
                        'balance' => 0,
                        'balance_in_dollars' => 0,
                        'currency' => 'BDT',
                    ]);
                }

                BankDeposit::create([
                    'bank_balance_id'  => $bank->id,
                    'user_id'          => Auth::id(),
                    'deposit_date'     => now(), 
                    'amount'           => $subTotal,
                    'amount_in_dollar' => 0,
                    'deposit_method'   => 'cash',
                    'note'             => 'Sales Return Refund - ' . $salesReturn->return_no,
                    'reference_no'     => 'RET-' . time(),
                ]);

                $bank->increment('balance', $subTotal);
            }

            DB::commit();

            return redirect()
                ->route('sales_returns.index')
                ->with('success', 'Sales Return updated successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {

            $salesReturn = SalesReturn::with('items')->findOrFail($id);

            // Reverse stock
            foreach ($salesReturn->items as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->decrement('stock', $item->quantity);
                }
            }

            $salesReturn->delete();

            DB::commit();

            return redirect()->route('sales_returns.index')
                ->with('success', 'Sales Return deleted successfully!');
        } catch (\Exception $e) {

            DB::rollback();

            return back()->with('error', $e->getMessage());
        }
    }
}
