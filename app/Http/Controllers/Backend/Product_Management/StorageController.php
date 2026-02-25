<?php

namespace App\Http\Controllers\Backend\Product_Management;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\Storage;
use App\Models\Manufacturer;
use App\Models\Supplier;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

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
        /* Normalize Checkboxes */
        $request->merge([
            'is_damaged' => $request->has('is_damaged') ? 1 : 0,
            'is_expired' => $request->has('is_expired') ? 1 : 0,
        ]);

        /* Prevent BOTH selected */
        if ($request->is_damaged == 1 && $request->is_expired == 1) {
            return back()
                ->withInput()
                ->withErrors([
                    'status_error' => 'Item cannot be both Damaged and Expired at the same time.'
                ]);
        }

        $validated = $request->validate([

            'product_id'      => 'required|exists:products,id',
            'supplier_id'     => 'required|exists:suppliers,id',
            'manufacturer_id' => 'required|exists:manufacturers,id',

            'rack_number'     => 'required|string|max:100',
            'box_number'      => 'required|string|max:100',
            'rack_no'         => 'required|string|max:100',
            'box_no'          => 'required|string|max:100',

            'rack_location'   => 'nullable|string|max:150',
            'box_location'    => 'nullable|string|max:150',

            'stock_quantity'  => 'required|integer|min:0',
            'alert_quantity'  => 'required|integer|min:0',

            'image_path'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',

            /* Toggles */
            'is_damaged' => 'required|in:0,1',
            'is_expired' => 'required|in:0,1',

            /* Damage */
            'damage_image'       => 'required_if:is_damaged,1|nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'damage_qty' => [
                'nullable',
                'integer',
                Rule::requiredIf($request->is_damaged == 1),
                Rule::when($request->is_damaged == 1, ['min:1']),
            ],

            'damage_solution'    => 'required_if:is_damaged,1|nullable|string|max:255',
            'damage_description' => 'required_if:is_damaged,1|nullable|string',

            /* Expired */
            'expired_image'       => 'required_if:is_expired,1|nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'expired_qty' => [
                'nullable',
                'integer',
                Rule::requiredIf($request->is_expired == 1),
                Rule::when($request->is_expired == 1, ['min:1']),
            ],
            'expired_solution'    => 'required_if:is_expired,1|nullable|string|max:255',
            'expired_description' => 'required_if:is_expired,1|nullable|string',
        ]);

        /* ==========================
       HANDLE MAIN IMAGE
    ========================== */
        if ($request->hasFile('image_path')) {

            if ($storage->image_path && file_exists(public_path($storage->image_path))) {
                @unlink(public_path($storage->image_path));
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
       DAMAGE LOGIC
    ========================== */
        if ($validated['is_damaged'] == 1) {

            /* ==========================
            FORCE QTY TO 0 IF NOT ACTIVE
            ========================== */

            if ($validated['is_damaged'] == 0) {
                $validated['damage_qty'] = 0;
            }

            if ($validated['is_expired'] == 0) {
                $validated['expired_qty'] = 0;
            }
            $validated['expired_solution'] = null;
            $validated['expired_description'] = null;

            if ($storage->expired_image && file_exists(public_path($storage->expired_image))) {
                @unlink(public_path($storage->expired_image));
            }

            $validated['expired_image'] = null;

            if ($request->hasFile('damage_image')) {

                if ($storage->damage_image && file_exists(public_path($storage->damage_image))) {
                    @unlink(public_path($storage->damage_image));
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

            // Reset damage if not selected
            $validated['damage_qty'] = 0;
            $validated['damage_solution'] = null;
            $validated['damage_description'] = null;

            if ($storage->damage_image && file_exists(public_path($storage->damage_image))) {
                @unlink(public_path($storage->damage_image));
            }

            $validated['damage_image'] = null;
        }

        /* ==========================
       EXPIRED LOGIC
    ========================== */
        if ($validated['is_expired'] == 1) {

            // Reset damage
            $validated['is_damaged'] = 0;
            $validated['damage_qty'] = 0;
            $validated['damage_solution'] = null;
            $validated['damage_description'] = null;

            if ($storage->damage_image && file_exists(public_path($storage->damage_image))) {
                @unlink(public_path($storage->damage_image));
            }

            $validated['damage_image'] = null;

            if ($request->hasFile('expired_image')) {

                if ($storage->expired_image && file_exists(public_path($storage->expired_image))) {
                    @unlink(public_path($storage->expired_image));
                }

                $file = $request->file('expired_image');
                $filename = 'expired_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $destinationPath = public_path('uploads/images/storage/expired');

                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                $file->move($destinationPath, $filename);
                $validated['expired_image'] = 'uploads/images/storage/expired/' . $filename;
            }
        } else {

            $validated['expired_qty'] = 0;
            $validated['expired_solution'] = null;
            $validated['expired_description'] = null;

            if ($storage->expired_image && file_exists(public_path($storage->expired_image))) {
                @unlink(public_path($storage->expired_image));
            }

            $validated['expired_image'] = null;
        }

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
