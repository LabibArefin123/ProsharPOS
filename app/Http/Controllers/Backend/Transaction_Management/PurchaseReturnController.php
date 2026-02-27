<?php

namespace App\Http\Controllers\Backend\Transaction_Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\PurchaseReturn;
use App\Models\PurchaseReturnItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class PurchaseReturnController extends Controller
{
    /* ===============================
       INDEX
    =============================== */
    public function index()
    {
        $returns = PurchaseReturn::with(['purchase', 'supplier'])
            ->latest()
            ->get();

        return view(
            'backend.transaction_management.purchase_returns.index',
            compact('returns')
        );
    }

    /* ===============================
       CREATE (FROM PURCHASE)
    =============================== */
    public function create(Purchase $purchase)
    {
        $purchase->load(['supplier', 'items.product']);

        return view(
            'backend.transaction_management.purchase_returns.create',
            compact('purchase')
        );
    }

    /* ===============================
       STORE
    =============================== */
    public function store(Request $request, Purchase $purchase)
    {
        $request->validate([
            'return_date' => 'required|date',
            'quantity'    => 'required|array',
        ]);

        DB::transaction(function () use ($request, $purchase) {

            $purchase->load('items');

            $return = PurchaseReturn::create([
                'purchase_id'  => $purchase->id,
                'supplier_id'  => $purchase->supplier_id,
                'return_date'  => $request->return_date,
                'reference_no' => $request->reference_no,
                'note'         => $request->note,
                'total_amount' => 0,
            ]);

            $total = 0;

            foreach ($purchase->items as $item) {

                $returnQty = $request->quantity[$item->id] ?? 0;

                if ($returnQty <= 0) {
                    continue;
                }

                // Prevent over-return
                if ($returnQty > $item->quantity) {
                    throw new \Exception("Return quantity exceeds purchased quantity.");
                }

                $subtotal = $returnQty * $item->unit_price;

                PurchaseReturnItem::create([
                    'purchase_return_id' => $return->id,
                    'product_id'         => $item->product_id,
                    'quantity'           => $returnQty,
                    'unit_price'         => $item->unit_price,
                    'subtotal'           => $subtotal,
                ]);

                $total += $subtotal;
            }

            $return->update(['total_amount' => $total]);

            // ✅ Correct Activity Log
            activity()
                ->causedBy(auth()->user())
                ->performedOn($return)
                ->withProperties([
                    'purchase_id'  => $purchase->id,
                    'reference_no' => $return->reference_no,
                    'return_date'  => $return->return_date,
                    'total_amount' => $total,
                ])
                ->log('Purchase Return Created');
        });

        return redirect()
            ->route('purchase_returns.index')
            ->with('success', 'Purchase return created successfully.');
    }

    /* ===============================
       SHOW
    =============================== */
    public function show(PurchaseReturn $purchaseReturn)
    {
        $purchaseReturn->load(['purchase', 'supplier', 'items.product']);

        return view(
            'backend.transaction_management.purchase_returns.show',
            compact('purchaseReturn')
        );
    }

    public function edit(PurchaseReturn $purchaseReturn)
    {
        $purchaseReturn->load(['purchase.items.product', 'items']);

        return view(
            'backend.transaction_management.purchase_returns.edit',
            compact('purchaseReturn')
        );
    }

    public function update(Request $request, PurchaseReturn $purchaseReturn)
    {
        $request->validate([
            'return_date' => 'required|date',
            'quantity'    => 'required|array',
        ]);

        DB::transaction(function () use ($request, $purchaseReturn) {

            // Store old data for activity log
            $oldData = [
                'return_date'  => $purchaseReturn->return_date,
                'reference_no' => $purchaseReturn->reference_no,
                'total_amount' => $purchaseReturn->total_amount,
            ];

            // Delete old items
            $purchaseReturn->items()->delete();

            $total = 0;

            $purchaseReturn->purchase->load('items');

            foreach ($purchaseReturn->purchase->items as $item) {

                $returnQty = $request->quantity[$item->id] ?? 0;

                if ($returnQty <= 0) {
                    continue;
                }

                if ($returnQty > $item->quantity) {
                    throw new \Exception("Return quantity exceeds purchased quantity.");
                }

                $subtotal = $returnQty * $item->unit_price;

                $purchaseReturn->items()->create([
                    'product_id' => $item->product_id,
                    'quantity'   => $returnQty,
                    'unit_price' => $item->unit_price,
                    'subtotal'   => $subtotal,
                ]);

                $total += $subtotal;
            }

            $purchaseReturn->update([
                'return_date'  => $request->return_date,
                'reference_no' => $request->reference_no,
                'note'         => $request->note,
                'total_amount' => $total,
            ]);

            // ✅ Activity Log for Update
            activity()
                ->causedBy(auth()->user())
                ->performedOn($purchaseReturn)
                ->withProperties([
                    'old' => $oldData,
                    'new' => [
                        'return_date'  => $purchaseReturn->return_date,
                        'reference_no' => $purchaseReturn->reference_no,
                        'total_amount' => $total,
                    ],
                ])
                ->log("Purchase Return Updated (Ref: {$purchaseReturn->reference_no})");
        });

        return redirect()
            ->route('purchase_returns.index')
            ->with('success', 'Purchase return updated successfully.');
    }
    /* ===============================
       DESTROY
    =============================== */
    public function destroy(PurchaseReturn $purchaseReturn)
    {
        DB::transaction(function () use ($purchaseReturn) {

            foreach ($purchaseReturn->items as $item) {
                Product::where('id', $item->product_id)
                    ->increment('stock', $item->quantity);
            }

            $purchaseReturn->delete();
        });

        return redirect()
            ->route('purchase_returns.index')
            ->with('success', 'Purchase return deleted successfully.');
    }
}
