<?php

namespace App\Http\Controllers;

use App\Models\Challan;
use App\Models\ChallanItem;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\Branch;
use App\Models\Warranty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChallanController extends Controller
{
    public function index()
    {
        $challans = Challan::with(['supplier', 'branch', 'citems.product'])
            ->orderBy('id', 'DESC')
            ->get();

        return view('transaction_management.challans.index', compact('challans'));
    }

    public function create()
    {
        $products   = Product::with(['brand', 'category'])->get();
        $warranties = Warranty::all();
        $suppliers  = Supplier::all();
        $branches   = Branch::all();

        return view('transaction_management.challans.create', compact(
            'products',
            'warranties',
            'suppliers',
            'branches'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'items'         => 'required|json',
            'supplier_id'   => 'required|exists:suppliers,id',
            'branch_id'     => 'required|exists:branches,id',
            'challan_no'    => 'nullable|string',
            'challan_date'  => 'required|date',
            'valid_until'   => 'required|date',
            'challan_ref'   => 'required|string',
            'note'          => 'nullable',
        ]);

        // Decode items JSON
        $products = json_decode($request->items, true);

        if (empty($products)) {
            return back()->withInput()->with('error', 'No products received.');
        }

        // Generate challan number if empty
        $challanNo = $request->challan_no ?: 'CH-' . now()->format('ymdHis') . rand(10, 99);

        // 1️⃣ CREATE MAIN CHALLAN
        $challan = Challan::create([
            'challan_no'    => $challanNo,
            'challan_date'  => $request->challan_date,
            'challan_ref'   => $request->challan_ref,
            'supplier_id'   => $request->supplier_id,
            'branch_id'     => $request->branch_id,
            'valid_until'   => $request->valid_until,
            'note'          => $request->note,
        ]);

        // 2️⃣ LOOP AND STORE ITEMS IN A SEPARATE TABLE
        foreach ($products as $item) {

            ChallanItem::create([
                'challan_id'     => $challan->id,
                'product_id'     => $item['id'],
                'challan_total'            => $item['challan_total'],
                'challan_bill'       => $item['challan_bill'],
                'challan_unbill'     => $item['challan_unbill'],
                'challan_foc'        => $item['challan_foc'],
                'warranty_id'    => $item['warranty_id'] ?? null,
            ]);
        }

        return redirect()->route('challans.index')
            ->with('success', 'Challan created successfully!');
    }


    public function show($id)
    {
        $challan = Challan::with(['supplier', 'product', 'branch', 'warranty'])
            ->findOrFail($id);

        return view('transaction_management.challans.show', compact('challan'));
    }

    public function edit($id)
    {
        $challan = Challan::with('citems.product')->findOrFail($id);

        $products = Product::orderBy('name')->get();
        $branches = Branch::orderBy('name')->get();
        $suppliers = Supplier::orderBy('name')->get();
        $warranties = Warranty::all();

        // Prepare edit items for JS cart
        $editItems = $challan->citems->map(function ($item) {
            return [
                'id' => $item->product_id,
                'name' => $item->product->name,
                'qty' => $item->challan_total,
                'bill_qty' => $item->challan_bill,
                'unbill_qty' => $item->challan_unbill,
                'foc_qty' => $item->challan_foc,
                'warranty_id' => $item->warranty_id,
                'warranty_period' => $item->warranty?->day_count ?? 0,
            ];
        });

        return view('transaction_management.challans.edit', compact(
            'challan',
            'products',
            'warranties',
            'branches',
            'suppliers',
            'editItems'
        ));
    }

    public function update(Request $request, $id)
    {
        $challan = Challan::findOrFail($id);

        $request->validate([
            'challan_date' => 'required|date',
            'status'       => 'required',
        ]);

        $challan->update([
            'challan_date'   => $request->challan_date,
            'supplier_id'    => $request->supplier_id,
            'branch_id'      => $request->branch_id,

            'challan_bill'   => $request->challan_bill,
            'challan_unbill' => $request->challan_unbill,
            'challan_foc'    => $request->challan_foc,

            'pdf_path'       => $request->pdf_path,
            'challan_ref'    => $request->challan_ref,
            'out_ref'        => $request->out_ref,

            'status'         => $request->status,
            'valid_until'    => $request->valid_until,
            'note'           => $request->note,

            'updated_by'     => Auth::id(),
        ]);

        return redirect()->route('challans.index')
            ->with('success', 'Challan updated successfully!');
    }

    public function destroy($id)
    {
        $challan = Challan::findOrFail($id);
        $challan->delete();

        return redirect()->route('challans.index')
            ->with('success', 'Challan deleted successfully!');
    }
}
