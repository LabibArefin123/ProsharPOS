<?php

namespace App\Http\Controllers\Backend\Product_Management;

use App\Http\Controllers\Controller;
use App\Models\Storage;
use App\Models\Manufacturer;
use App\Models\Supplier;
use App\Models\Product;
use Illuminate\Http\Request;

class StorageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $storages = Storage::with(['product', 'supplier', 'manufacturer'])
            ->orderBy('id', 'asc')->get();

        return view('backend.product_management.storage.index', compact('storages'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $suppliers = Supplier::all();
        $products = Product::orderBy('name', 'asc')->get();
        $manufacturers = Manufacturer::orderBy('name', 'asc')->get();

        return view('backend.product_management.storage.create', compact(
            'suppliers',
            'manufacturers',
            'products'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id'         => 'required|exists:products,id',
            'supplier_id'        => 'required|exists:suppliers,id',
            'manufacturer_id'    => 'required|exists:manufacturers,id',
            'rack_number'        => 'required|string|max:100',
            'box_number'         => 'required|string|max:100',
            'rack_no'            => 'required|string|max:100',
            'box_no'             => 'required|string|max:100',
            'rack_location'      => 'required|string|max:100',
            'box_location'       => 'required|string|max:100',
            'stock_quantity'     => 'required|integer',
            'alert_quantity'     => 'required|integer',
            'image_path'         => 'nullable|image|max:5120',
        ]);

        // Handle uploaded image from modal
        if ($request->hasFile('image_path')) {
            $file = $request->file('image_path');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('uploads/images/stock');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $file->move($destinationPath, $filename);
            $validated['image_path'] = 'uploads/images/stock/' . $filename;
        }

        Storage::create($validated);

        return redirect()->route('storages.index')->with('success', 'Storage created successfully');
    }
    /**
     * Display the specified resource.
     */
    public function show(Storage $storage)
    {
        // eager load relations so show.blade.php doesn’t break
        $storage->load(['product', 'supplier', 'manufacturer']);
        return view('backend.product_management.storage.show', compact('storage'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Storage $storage)
    {

        $suppliers = Supplier::all();
        $products = Product::orderBy('name', 'asc')->get();
        $manufacturers = Manufacturer::orderBy('name', 'asc')->get();
        return view('backend.product_management.storage.edit', compact(
            'storage',
            'suppliers',
            'products',
            'manufacturers'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Storage $storage)
    {
        $validated = $request->validate([
            'product_id'          => 'required|exists:products,id',
            'supplier_id'         => 'required|exists:suppliers,id',
            'manufacturer_id'     => 'required|exists:manufacturers,id',

            'rack_number'         => 'required|string|max:100',
            'box_number'          => 'required|string|max:100',
            'rack_no'             => 'required|string|max:100',
            'box_no'              => 'required|string|max:100',

            'rack_location'       => 'nullable|string|max:150',
            'box_location'        => 'nullable|string|max:150',

            'stock_quantity'      => 'required|integer|min:0',
            'alert_quantity'      => 'required|integer|min:0',

            /* Main Image */
            'image_path'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',

            /* Damage Toggle */
            'is_damaged'          => 'nullable|boolean',

            /* Damage Fields */
            'damage_qty'          => 'nullable|integer|min:0',
            'damage_solution'     => 'nullable|string|max:255',
            'damage_description'  => 'nullable|string',
            'damage_image'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        /* Normalize checkbox (unchecked = false) */
        $validated['is_damaged'] = $request->has('is_damaged');

        /* ==========================
       Handle MAIN Image Update
    ========================== */
        if ($request->hasFile('image_path')) {

            if ($storage->image_path && file_exists(public_path($storage->image_path))) {
                unlink(public_path($storage->image_path));
            }

            $file = $request->file('image_path');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('uploads/images/storage');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $file->move($destinationPath, $filename);
            $validated['image_path'] = 'uploads/images/storage/' . $filename;
        }

        /* ==========================
       Handle DAMAGE Logic
    ========================== */
        if ($validated['is_damaged']) {

            // Upload damage image
            if ($request->hasFile('damage_image')) {

                if ($storage->damage_image && file_exists(public_path($storage->damage_image))) {
                    unlink(public_path($storage->damage_image));
                }

                $file = $request->file('damage_image');
                $filename = 'damage_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $destinationPath = public_path('uploads/images/storage/damage');

                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                $file->move($destinationPath, $filename);
                $validated['damage_image'] = 'uploads/images/storage/damage/' . $filename;
            }
        } else {
            /* Reset damage data if toggle = NO */
            $validated['damage_qty'] = 0;
            $validated['damage_solution'] = null;
            $validated['damage_description'] = null;

            if ($storage->damage_image && file_exists(public_path($storage->damage_image))) {
                unlink(public_path($storage->damage_image));
            }

            $validated['damage_image'] = null;
        }

        /* ==========================
       Update Storage
    ========================== */
        $storage->update($validated);

        return redirect()
            ->route('storages.index')
            ->with('success', 'Storage updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Storage $storage)
    {
        // delete image if exists
        if ($storage->image && file_exists(public_path($storage->image))) {
            unlink(public_path($storage->image));
        }

        $storage->delete();

        return redirect()->route('storages.index')->with('success', 'Storage deleted successfully');
    }
}
