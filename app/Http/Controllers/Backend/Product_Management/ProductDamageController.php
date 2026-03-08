<?php

namespace App\Http\Controllers\Backend\Product_Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductDamage;
use App\Models\Storage;

class ProductDamageController extends Controller
{

    /**
     * Display listing
     */
    public function index()
    {
        $damages = ProductDamage::with(['product', 'storage'])
            ->latest()
            ->paginate(15);

        return view(
            'backend.product_management.product_damage.index',
            compact('damages')
        );
    }


    /**
     * Show create form
     */
    public function create()
    {
        $storages = Storage::with('product')->get();

        return view(
            'backend.product_management.product_damage.create',
            compact('storages')
        );
    }


    /**
     * Store damage
     */
    public function store(Request $request)
    {

        $validated = $request->validate([

            'storage_id' => 'required|exists:storages,id',

            'damage_qty' => 'required|integer|min:1',

            'damage_description' => 'nullable|string',

            'damage_solution' => 'nullable|string|max:255',

            'damage_note' => 'nullable|string',

            'damage_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120'

        ]);


        $storage = Storage::findOrFail($request->storage_id);


        /*
        |--------------------------------------------------------------------------
        | IMAGE UPLOAD
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('damage_image')) {

            $file = $request->file('damage_image');

            $filename = 'damage_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            $destination = public_path('uploads/images/product_damage');

            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }

            $file->move($destination, $filename);

            $validated['damage_image'] = 'uploads/images/product_damage/' . $filename;
        }


        /*
        |--------------------------------------------------------------------------
        | CREATE DAMAGE RECORD
        |--------------------------------------------------------------------------
        */

        $validated['product_id'] = $storage->product_id;

        ProductDamage::create($validated);


        /*
        |--------------------------------------------------------------------------
        | UPDATE STORAGE STATUS
        |--------------------------------------------------------------------------
        */

        $storage->update([
            'is_damaged' => 1
        ]);


        return redirect()
            ->route('product_damages.index')
            ->with('success', 'Product damage recorded successfully');
    }


    /**
     * Show single record
     */
    public function show(string $id)
    {
        $damage = ProductDamage::with(['product', 'storage'])->findOrFail($id);

        return view(
            'backend.product_management.product_damage.show',
            compact('damage')
        );
    }


    /**
     * Show edit form
     */
    public function edit(string $id)
    {

        $productDamage = ProductDamage::findOrFail($id);

        $storages = Storage::with('product')->get();

        return view(
            'backend.product_management.product_damage.edit',
            compact('productDamage', 'storages')
        );
    }


    /**
     * Update damage
     */
    public function update(Request $request, string $id)
    {

        $damage = ProductDamage::findOrFail($id);

        $validated = $request->validate([

            'storage_id' => 'required|exists:storages,id',

            'damage_qty' => 'required|integer|min:1',

            'damage_description' => 'nullable|string',

            'damage_solution' => 'nullable|string|max:255',

            'damage_note' => 'nullable|string',

            'damage_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120'

        ]);


        $storage = Storage::findOrFail($request->storage_id);


        /*
        |--------------------------------------------------------------------------
        | IMAGE UPDATE
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('damage_image')) {

            if ($damage->damage_image && file_exists(public_path($damage->damage_image))) {
                unlink(public_path($damage->damage_image));
            }

            $file = $request->file('damage_image');

            $filename = 'damage_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            $destination = public_path('uploads/images/product_damage');

            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }

            $file->move($destination, $filename);

            $validated['damage_image'] = 'uploads/images/product_damage/' . $filename;
        }


        /*
        |--------------------------------------------------------------------------
        | UPDATE RECORD
        |--------------------------------------------------------------------------
        */

        $validated['product_id'] = $storage->product_id;

        $damage->update($validated);


        /*
        |--------------------------------------------------------------------------
        | UPDATE STORAGE STATUS
        |--------------------------------------------------------------------------
        */

        $storage->update([
            'is_damaged' => 1
        ]);


        return redirect()
            ->route('product_damages.index')
            ->with('success', 'Product damage updated successfully');
    }


    /**
     * Delete damage
     */
    public function destroy(string $id)
    {

        $damage = ProductDamage::findOrFail($id);

        $storage = Storage::find($damage->storage_id);


        /*
        |--------------------------------------------------------------------------
        | DELETE IMAGE
        |--------------------------------------------------------------------------
        */

        if ($damage->damage_image && file_exists(public_path($damage->damage_image))) {
            unlink(public_path($damage->damage_image));
        }


        $damage->delete();


        /*
        |--------------------------------------------------------------------------
        | RESET STORAGE DAMAGE FLAG
        |--------------------------------------------------------------------------
        */

        if ($storage) {

            $storage->update([
                'is_damaged' => 0
            ]);
        }


        return redirect()
            ->route('product_damages.index')
            ->with('success', 'Damage record deleted successfully');
    }
}
