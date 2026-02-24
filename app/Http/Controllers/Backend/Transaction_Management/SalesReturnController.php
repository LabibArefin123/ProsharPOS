<?php

namespace App\Http\Controllers\Backend\Transaction_Management;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SalesReturn;
use App\Models\SalesReturnItem;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Branch;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $invoices  = Invoice::with('customer')->get();
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

            $items = json_decode($request->items, true);

            if (empty($items)) {
                return back()->withInput()->with('error', 'No products received.');
            }

            $returnNo = 'SR-' . now()->format('ymdHis') . rand(10, 99);

            $subTotal = 0;

            // CREATE MAIN RETURN
            $salesReturn = SalesReturn::create([
                'return_no'     => $returnNo,
                'invoice_id'    => $request->invoice_id,
                'customer_id'   => $request->customer_id,
                'branch_id'     => $request->branch_id,
                'return_date'   => $request->return_date,
                'refund_method' => $request->refund_method,
                'note'          => $request->note,
                'created_by'    => Auth::id(),
            ]);

            // STORE ITEMS + STOCK INCREMENT
            foreach ($items as $item) {

                $subtotal = $item['quantity'] * $item['price'];
                $subTotal += $subtotal;

                SalesReturnItem::create([
                    'sales_return_id' => $salesReturn->id,
                    'product_id'      => $item['id'],
                    'quantity'        => $item['quantity'],
                    'price'           => $item['price'],
                    'subtotal'        => $subtotal,
                ]);

                // Increase stock
                $product = Product::find($item['id']);
                if ($product) {
                    $product->increment('stock', $item['quantity']);
                }
            }

            // Update totals
            $salesReturn->update([
                'sub_total' => $subTotal,
                'total_return_amount' => $subTotal,
                'refund_amount' => $subTotal,
            ]);

            // OPTIONAL: Adjust Invoice Due
            $invoice = Invoice::find($request->invoice_id);

            if ($request->refund_method === 'adjust_due' && $invoice) {

                $invoice->paid_amount -= $subTotal;
                $invoice->total -= $subTotal;
                $invoice->save();
            }

            // OPTIONAL: Insert Negative Payment Entry
            if ($request->refund_method === 'cash' && $invoice) {

                Payment::create([
                    'payment_id'   => 'RET-' . time(),
                    'invoice_id'   => $invoice->id,
                    'paid_amount'  => -$subTotal,
                    'due_amount'   => 0,
                    'paid_by'      => Auth::id(),
                    'payment_type' => 'return',
                ]);
            }

            DB::commit();

            return redirect()->route('sales_returns.index')
                ->with('success', 'Sales Return created successfully!');
        } catch (\Exception $e) {

            DB::rollback();

            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function show($id)
    {
        $return = SalesReturn::with(['invoice', 'customer', 'branch', 'items.product'])
            ->findOrFail($id);

        return view('backend.transaction_management.sales_returns.show', compact('return'));
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
