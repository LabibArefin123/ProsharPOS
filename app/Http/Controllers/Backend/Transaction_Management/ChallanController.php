<?php

namespace App\Http\Controllers\Backend\Transaction_Management;

use App\Http\Controllers\Controller;
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

        // Convert items to the exact format used by JavaScript
        $editItems = $challan->citems->map(function ($item) {
            return [
                'id' => $item->product_id,
                'name' => $item->product->name ?? '',
                'challan_total' => $item->challan_total,
                'challan_bill' => $item->challan_bill,
                'challan_unbill' => $item->challan_unbill,
                'challan_foc' => $item->challan_foc,
                'warranty_id' => $item->warranty_id,
            ];
        });

        return view('transaction_management.challans.edit', [
            'challan'     => $challan,
            'editItems'   => $editItems,
            'products'    => Product::all(),
            'warranties'  => Warranty::all(),
            'suppliers'   => Supplier::all(),
            'branches'    => Branch::all(),
        ]);
    }


    public function update(Request $request, $id)
    {
        $challan = Challan::findOrFail($id);

        $request->validate([
            'items'         => 'required|json',
            'supplier_id'   => 'required|exists:suppliers,id',
            'branch_id'     => 'required|exists:branches,id',
            'challan_date'  => 'required|date',
            'valid_until'   => 'required|date',
            'challan_ref'   => 'required|string',
            'note'          => 'nullable',
            'out_ref'       => 'nullable',
            'challan_doc'   => 'nullable|file|mimes:pdf,jpg,png',
        ]);

        // Decode items
        $products = json_decode($request->items, true);

        if (empty($products)) {
            return back()->withInput()->with('error', 'No products received.');
        }

        // --- FILE UPLOAD ---
        $fileName = $challan->challan_doc;
        if ($request->hasFile('challan_doc')) {
            $fileName = time() . '-' . $request->file('challan_doc')->getClientOriginalName();
            $request->file('challan_doc')->move(public_path('uploads/files/challans'), $fileName);
        }

        // UPDATE MAIN CHALLAN
        $challan->update([
            'challan_date' => $request->challan_date,
            'supplier_id'  => $request->supplier_id,
            'branch_id'    => $request->branch_id,
            'challan_ref'  => $request->challan_ref,
            'out_ref'      => $request->out_ref,
            'valid_until'  => $request->valid_until,
            'note'         => $request->note,
            'challan_doc'  => $fileName,
        ]);

        // DELETE OLD ITEMS
        ChallanItem::where('challan_id', $challan->id)->delete();

        // INSERT NEW ITEMS
        foreach ($products as $item) {
            ChallanItem::create([
                'challan_id'      => $challan->id,
                'product_id'      => $item['id'],
                'challan_total'   => $item['challan_total'],
                'challan_bill'    => $item['challan_bill'],
                'challan_unbill'  => $item['challan_unbill'],
                'challan_foc'     => $item['challan_foc'],
                'warranty_id'     => $item['warranty_id'] ?? null,
            ]);
        }

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
