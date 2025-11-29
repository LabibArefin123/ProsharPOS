<?php

// app/Http/Controllers/InvoiceController.php
namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Invoice;
use App\Models\Customer;
use App\Models\InvoiceItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with(['customer', 'branch'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('transaction_management.invoice.index', compact('invoices'));
    }

    public function create()
    {
        return view('transaction_management.invoice.create', [
            'customers' => Customer::all(),
            'products' => Product::with('category', 'brand')->get(),
            'branches' => Branch::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'branch_id' => 'required|exists:branches,id',
            'items' => 'required|string',
            'discount_type' => 'nullable|in:percentage,flat',
            'discount_percent' => 'nullable|numeric',
            'flat_discount' => 'nullable|numeric',
        ]);

        $items = json_decode($request->items, true);

        if (!$items || !is_array($items)) {
            return back()->withErrors(['items' => 'Invalid product items.']);
        }

        DB::beginTransaction();

        try {
            $invoice = Invoice::create([
                'customer_id' => $request->customer_id,
                'branch_id' => $request->branch_id,
                'discount_type' => $request->discount_type,
                'discount_percent' => $request->discount_percent,
                'flat_discount' => $request->flat_discount,
                'created_by' => auth()->id(),
            ]);

            foreach ($items as $item) {
                if (!isset($item['id'], $item['qty'], $item['price'])) {
                    throw new \Exception("Missing product data (id, qty, price)");
                }

                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'product_id' => $item['id'],
                    'quantity' => $item['qty'],
                    'price' => $item['price'],
                    'discount' => $item['discount'] ?? 0,
                    'amount' => ($item['qty'] * $item['price']) - ($item['discount'] ?? 0),
                ]);
            }

            DB::commit();

            return redirect()->route('invoices.index')->with('success', 'Invoice created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
