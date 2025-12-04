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
        $invoices = Invoice::with(['customer', 'branch', 'paidByUser'])
            ->orderBy('id', 'asc')->get();

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
        // Validate only the fields you actually submit
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'branch_id' => 'required|exists:branches,id',
            'items' => 'required|string',
            'invoice_id' => 'required|string',
            'status' => 'required|string',
            'invoice_date' => 'required|date',
            'discount_type' => 'nullable|in:percentage,flat',
            'discount_percent' => 'nullable|numeric',
            'flat_discount' => 'nullable|numeric',
        ]);

        // Decode the items JSON sent from JS
        $payload = json_decode($request->items, true);

        // Default values
        $items = $payload['items'] ?? [];
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

                // Save discount type as selected
                'discount_type' => $request->discount_type,
                'discount_percent' => $request->discount_percent,
                'flat_discount' => $request->flat_discount,

                // Values from JS payload
                'sub_total' => $subTotal,
                'discount_value' => $discountValue,
                'total' => $total,
                'items' => $items,

                'created_by' => auth()->id(),
            ]);

            // Save invoice items
            foreach ($items as $item) {
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

    public function show(Invoice $invoice)
    {
        // Eager load relations properly
        $invoice->load(['customer', 'branch', 'invoiceItems.product']);
        return view('transaction_management.invoice.show', compact('invoice'));
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
            'items' => 'required|string',
            'invoice_id' => 'required|string|unique:invoices,invoice_id,' . $invoice->id,
            'status' => 'required|string',
            'invoice_date' => 'required|date',
            'discount_type' => 'nullable|in:percentage,flat',
            'discount_percent' => 'nullable|numeric',
            'flat_discount' => 'nullable|numeric',
        ]);

        $payload = json_decode($request->items, true);

        $items = $payload['items'] ?? [];
        $subTotal = $payload['sub_total'] ?? 0;
        $discountValue = $payload['discount_value'] ?? 0;
        $total = $payload['total'] ?? 0;

        DB::beginTransaction();
        try {
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
                'items' => $items,
            ]);

            // Remove old items
            InvoiceItem::where('invoice_id', $invoice->id)->delete();

            foreach ($items as $item) {
                if (!isset($item['id'], $item['qty'], $item['price'])) {
                    throw new \Exception("Invalid item data.");
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

    public function destroy(Invoice $invoice)
    {
        DB::beginTransaction();

        try {
            // Delete related invoice items first
            InvoiceItem::where('invoice_id', $invoice->id)->delete();

            // Delete the invoice itself
            $invoice->delete();

            DB::commit();

            return redirect()->route('invoices.index')->with('success', 'Invoice deleted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('invoices.index')->withErrors([
                'error' => 'Failed to delete invoice: ' . $e->getMessage()
            ]);
        }
    }
}
