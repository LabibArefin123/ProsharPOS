<?php

namespace App\Http\Controllers;

use App\Models\Challan;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Branch;
use App\Models\Warranty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChallanController extends Controller
{
    public function index()
    {
        $challans = Challan::with(['customer', 'product', 'branch', 'warranty'])->get();
        return view('transaction_management.challans.index', compact('challans'));
    }
    public function create()
    {
        $products = Product::with(['brand', 'category'])->get();
        $warranties = Warranty::all();
        $customers = Customer::all();
        $branches = Branch::all();
        return view('transaction_management.challans.create', compact('products', 'warranties', 'customers', 'branches'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'products' => 'required|json',
            'challan_date' => 'required|date',
            'payment_term' => 'required',
            'status' => 'required',
        ]);

        $products = json_decode($request->products, true);

        foreach ($products as $item) {
            Challan::create([
                'challan_no' => 'CH-' . now()->format('ymdHis') . rand(10, 99),
                'challan_date' => $request->challan_date,
                'customer_id' => $request->customer_id,
                'branch_id' => $request->branch_id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'warranty_id' => $item['warranty_id'] ?? null,
                'status' => $request->status,
                'note' => $request->note,
                'created_by' => Auth::id(),
            ]);
        }

        return redirect()->route('challans.index')->with('success', 'Challan(s) created successfully!');
    }

    public function show($id)
    {
        $challan = Challan::with(['customer', 'product', 'branch', 'warranty', 'creator'])->findOrFail($id);
        return view('transaction_management.challans.show', compact('challan'));
    }
}
