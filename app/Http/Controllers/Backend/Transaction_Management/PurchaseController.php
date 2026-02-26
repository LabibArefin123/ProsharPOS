<?php

namespace App\Http\Controllers\Backend\Transaction_Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PurchaseItem;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    /* ===============================
       INDEX
    =============================== */
    public function index()
    {
        $purchases = Purchase::with('supplier')
            ->join('suppliers', 'purchases.supplier_id', '=', 'suppliers.id')
            ->orderBy('suppliers.name', 'asc')
            ->select('purchases.*')
            ->get();

        return view('backend.transaction_management.purchases.index', compact('purchases'));
    }

    /* ===============================
       CREATE
    =============================== */
    public function create()
    {
        $suppliers = Supplier::orderBy('name', 'asc')->get();
        $products  = Product::orderBy('name', 'asc')->get();

        return view(
            'backend.transaction_management.purchases.create',
            compact('suppliers', 'products')
        );
    }

    /* ===============================
       STORE
    =============================== */
    public function store(Request $request)
    {
        $request->validate([
            'supplier_id'   => 'required|exists:suppliers,id',
            'purchase_date' => 'required|date',
            'product_id'    => 'required|array',
            'quantity'      => 'required|array',
            'unit_price'    => 'required|array',
        ]);

        DB::transaction(function () use ($request) {

            $purchase = Purchase::create([
                'supplier_id'   => $request->supplier_id,
                'purchase_date' => $request->purchase_date,
                'reference_no'  => $request->reference_no,
                'note'          => $request->note,
                'total_amount'  => 0,
            ]);

            $total = 0;

            foreach ($request->product_id as $key => $productId) {

                if (!$productId) {
                    continue;
                }

                $qty       = $request->quantity[$key];
                $price     = $request->unit_price[$key];
                $subtotal  = $qty * $price;

                PurchaseItem::create([
                    'purchase_id' => $purchase->id,
                    'product_id'  => $productId,
                    'quantity'    => $qty,
                    'unit_price'  => $price,
                    'subtotal'    => $subtotal,
                ]);

                // (Optional) Update product stock here if needed
                // Product::where('id', $productId)->increment('stock', $qty);

                $total += $subtotal;
            }

            $purchase->update(['total_amount' => $total]);
        });

        return redirect()
            ->route('purchases.index')
            ->with('success', 'Purchase added successfully.');
    }

    /* ===============================
       SHOW
    =============================== */
    public function show(Purchase $purchase)
    {
        $purchase->load(['supplier', 'items.product']);

        return view(
            'backend.transaction_management.purchases.show',
            compact('purchase')
        );
    }

    /* ===============================
       EDIT
    =============================== */
    public function edit(Purchase $purchase)
    {
        $purchase->load(['items.product']);

        $suppliers = Supplier::orderBy('name', 'asc')->get();
        $products  = Product::orderBy('name', 'asc')->get();

        return view(
            'backend.transaction_management.purchases.edit',
            compact('purchase', 'suppliers', 'products')
        );
    }

    /* ===============================
       UPDATE
    =============================== */
    public function update(Request $request, Purchase $purchase)
    {
        $request->validate([
            'supplier_id'   => 'required|exists:suppliers,id',
            'purchase_date' => 'required|date',
            'product_id'    => 'required|array',
            'quantity'      => 'required|array',
            'unit_price'    => 'required|array',
        ]);

        DB::transaction(function () use ($request, $purchase) {

            $purchase->update([
                'supplier_id'   => $request->supplier_id,
                'purchase_date' => $request->purchase_date,
                'reference_no'  => $request->reference_no,
                'note'          => $request->note,
            ]);

            // Remove old items
            PurchaseItem::where('purchase_id', $purchase->id)->delete();

            $total = 0;

            foreach ($request->product_id as $key => $productId) {

                if (!$productId) {
                    continue;
                }

                $qty      = $request->quantity[$key];
                $price    = $request->unit_price[$key];
                $subtotal = $qty * $price;

                PurchaseItem::create([
                    'purchase_id' => $purchase->id,
                    'product_id'  => $productId,
                    'quantity'    => $qty,
                    'unit_price'  => $price,
                    'subtotal'    => $subtotal,
                ]);

                $total += $subtotal;
            }

            $purchase->update(['total_amount' => $total]);
        });

        return redirect()
            ->route('purchases.index')
            ->with('success', 'Purchase updated successfully.');
    }

    /* ===============================
       DESTROY
    =============================== */
    public function destroy(Purchase $purchase)
    {
        DB::transaction(function () use ($purchase) {
            PurchaseItem::where('purchase_id', $purchase->id)->delete();
            $purchase->delete();
        });

        return redirect()
            ->route('purchases.index')
            ->with('success', 'Purchase deleted successfully.');
    }
}
