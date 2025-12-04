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
            'items' => 'nullable|string',
            'invoice_id' => 'required|string',
            'status' => 'required|string',
            'invoice_date' => 'required|date',
            'discount_type' => 'nullable|in:percentage,flat',
            'discount_percent' => 'nullable|numeric',
            'flat_discount' => 'nullable|numeric',
        ]);

        $payload = json_decode($request->items, true);

        if (!$payload || !isset($payload['items']) || !is_array($payload['items'])) {
            return back()->withErrors(['items' => 'Invalid product items.']);
        }

        $items = $payload['items'];
        $subTotal = $payload['sub_total'] ?? 0;
        $discountValue = $payload['discount_value'] ?? 0;
        $total = $payload['total'] ?? 0;

        DB::beginTransaction();
        try {
            $invoice = Invoice::create([
                'customer_id' => $request->customer_id,
                'branch_id' => $request->branch_id,
                'invoice_id' => $request->invoice_id,
                'invoice_date' => $request->invoice_date,
                'status' => $request->status,
                'discount_type' => $request->discount_type,
                'discount_percent' => $request->discount_percent,
                'flat_discount' => $request->flat_discount,
                'sub_total' => $subTotal,
                'discount_value' => $discountValue,
                'total' => $total,
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


    public function edit(Invoice $invoice)
    {
        $customers = Customer::all();
        $products = Product::with('category', 'brand')->get();
        $branches = Branch::all();

        return view('transaction_management.invoice.edit', compact('invoice', 'customers', 'products', 'branches'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'branch_id' => 'required|exists:branches,id',
            'items' => 'nullable|string',
            'invoice_id' => 'required|string',
            'status' => 'required|string',
            'invoice_date' => 'required|date',
            'discount_type' => 'nullable|in:percentage,flat',
            'discount_percent' => 'nullable|numeric',
            'flat_discount' => 'nullable|numeric',
        ]);

        $payload = json_decode($request->items, true);

        if (!$payload || !isset($payload['items']) || !is_array($payload['items'])) {
            return back()->withErrors(['items' => 'Invalid product items.']);
        }

        $items = $payload['items'];
        $subTotal = $payload['sub_total'] ?? 0;
        $discountValue = $payload['discount_value'] ?? 0;
        $total = $payload['total'] ?? 0;

        DB::beginTransaction();

        try {
            // Update invoice details
            $invoice->update([
                'customer_id' => $request->customer_id,
                'branch_id' => $request->branch_id,
                'invoice_id' => $request->invoice_id,
                'invoice_date' => $request->invoice_date,
                'status' => $request->status,
                'discount_type' => $request->discount_type,
                'discount_percent' => $request->discount_percent,
                'flat_discount' => $request->flat_discount,
                'sub_total' => $subTotal,
                'discount_value' => $discountValue,
                'total' => $total,
            ]);

            // Delete old items
            $invoice->items()->delete();

            // Add new/updated items
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
            return redirect()->route('invoices.index')->with('success', 'Invoice updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
