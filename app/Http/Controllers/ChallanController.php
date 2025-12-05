<?php

namespace App\Http\Controllers;

use App\Models\Challan;
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
        $challans = Challan::with(['supplier', 'product', 'branch', 'warranty'])
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
            'products'      => 'required|json',
            'supplier_id' => 'required|exists:suppliers,id',
            'branch_id' => 'required|exists:branches,id',
            'challan_no'  => 'required|date',
            'challan_date'  => 'required|date',
            'challan_ref'  => 'required|date',
            'status'        => 'required',
        ]);

        $products = json_decode($request->products, true);

        // Generate 1 challan number for all rows
        $challanNo = 'CH-' . now()->format('ymdHis') . rand(10, 99);

        // Calculate challan totals
        $challan_total  = array_sum(array_column($products, 'quantity'));
        $challan_bill   = $request->challan_bill ?? 0;
        $challan_unbill = $request->challan_unbill ?? 0;
        $challan_foc    = $request->challan_foc ?? 0;

        foreach ($products as $item) {
            Challan::create([
                'challan_no'     => $challanNo,
                'challan_date'   => $request->challan_date,
                'challan_ref'   => $request->challan_ref,
                'supplier_id'    => $request->supplier_id,
                'branch_id'      => $request->branch_id,
                'product_id'     => $item['product_id'],
                'quantity'       => $item['quantity'],

                'challan_total'  => $challan_total,
                'challan_bill'   => $challan_bill,
                'challan_unbill' => $challan_unbill,
                'challan_foc'    => $challan_foc,

                'warranty_id'    => $item['warranty_id'] ?? null,
                'warranty_period' => $item['warranty_period'] ?? null,
                'serial_no'      => $item['serial_no'] ?? null,

                'status'         => $request->status,
                'valid_until'    => $request->valid_until,
                'note'           => $request->note,

                'created_by'     => Auth::id(),
            ]);
        }

        return redirect()->route('challans.index')
            ->with('success', 'Challan created successfully!');
    }

    public function show($id)
    {
        $challan = Challan::with(['supplier', 'product', 'branch', 'warranty', 'creator'])
            ->findOrFail($id);

        return view('transaction_management.challans.show', compact('challan'));
    }

    public function edit($id)
    {
        $challan    = Challan::findOrFail($id);
        $products   = Product::with(['brand', 'category'])->get();
        $warranties = Warranty::all();
        $suppliers  = Supplier::all();
        $branches   = Branch::all();

        return view('transaction_management.challans.edit', compact(
            'challan',
            'products',
            'warranties',
            'suppliers',
            'branches'
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
