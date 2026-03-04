<?php

namespace App\Http\Controllers\Backend\Product_Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductInspection;
use App\Models\Storage;
use Illuminate\Support\Facades\Auth;

class ProductInspectionController extends Controller
{
    /**
     * Display a listing of inspections.
     */
    public function index()
    {
        $inspections = ProductInspection::with(['storage.product', 'user'])
            ->latest()
            ->get();

        return view('backend.product_management.product_inspections.index', compact('inspections'));
    }

    /**
     * Show the form for creating a new inspection.
     */
    public function create()
    {
        $storages = Storage::with('product')->get();

        return view('backend.product_management.product_inspections.create', compact('storages'));
    }

    /**
     * Store a newly created inspection.
     */
    public function store(Request $request)
    {
        $request->validate([
            'storage_id'         => 'required|exists:storages,id',
            'inspection_type'    => 'required|string|max:100',
            'status'             => 'required|in:passed,failed,partial',
            'checked_quantity'   => 'nullable|integer|min:0',
            'defective_quantity' => 'nullable|integer|min:0|lte:checked_quantity',
            'notes'              => 'nullable|string',
        ]);

        ProductInspection::create([
            'storage_id'         => $request->storage_id,
            'user_id'            => Auth::id(),
            'inspection_type'    => $request->inspection_type,
            'status'             => $request->status,
            'checked_quantity'   => $request->checked_quantity,
            'defective_quantity' => $request->defective_quantity,
            'notes'              => $request->notes,
        ]);

        return redirect()->route('product_inspections.index')
            ->with('success', 'Product inspection created successfully.');
    }

    /**
     * Display specific inspection.
     */
    public function show(string $id)
    {
        $inspection = ProductInspection::with(['storage.product', 'user'])
            ->findOrFail($id);

        return view('backend.product_management.product_inspections.show', compact('inspection'));
    }

    /**
     * Show edit form.
     */
    public function edit(string $id)
    {
        $inspection = ProductInspection::findOrFail($id);
        $storages   = Storage::with('product')->get();

        return view('backend.product_management.product_inspections.edit', compact('inspection', 'storages'));
    }

    /**
     * Update inspection.
     */
    public function update(Request $request, string $id)
    {
        $inspection = ProductInspection::findOrFail($id);

        $request->validate([
            'storage_id'         => 'required|exists:storages,id',
            'inspection_type'    => 'required|string|max:100',
            'status'             => 'required|in:passed,failed,partial',
            'checked_quantity'   => 'nullable|integer|min:0',
            'defective_quantity' => 'nullable|integer|min:0|lte:checked_quantity',
            'notes'              => 'nullable|string',
        ]);

        $inspection->update([
            'storage_id'         => $request->storage_id,
            'inspection_type'    => $request->inspection_type,
            'status'             => $request->status,
            'checked_quantity'   => $request->checked_quantity,
            'defective_quantity' => $request->defective_quantity,
            'notes'              => $request->notes,
            'user_id'            => Auth::id(),
        ]);

        return redirect()->route('product_inspections.index')
            ->with('success', 'Product inspection updated successfully.');
    }

    /**
     * Delete inspection.
     */
    public function destroy(string $id)
    {
        $inspection = ProductInspection::findOrFail($id);
        $inspection->delete();

        return redirect()->route('product_inspections.index')
            ->with('success', 'Product inspection deleted successfully.');
    }
}
