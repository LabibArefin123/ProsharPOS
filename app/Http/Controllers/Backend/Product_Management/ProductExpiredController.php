<?php

namespace App\Http\Controllers\Backend\Product_Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductExpiry;
use App\Models\Storage;

class ProductExpiredController extends Controller
{

    /**
     * Display listing
     */
    public function index()
    {
        $expiries = ProductExpiry::with(['product', 'storage'])
            ->latest()
            ->paginate(15);

        return view(
            'backend.product_management.product_expiry.index',
            compact('expiries')
        );
    }


    /**
     * Show create form
     */
    public function create()
    {
        $storages = Storage::with('product')->get();

        return view(
            'backend.product_management.product_expiry.create',
            compact('storages')
        );
    }


    /**
     * Store expiry
     */
    public function store(Request $request)
    {

        $validated = $request->validate([

            'storage_id' => 'required|exists:storages,id',

            'expired_qty' => 'required|integer|min:1',

            'expiry_description' => 'nullable|string',

            'error_solution' => 'nullable|string|max:255',

            'expiry_note' => 'nullable|string',

            'expiry_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120'

        ]);


        $storage = Storage::findOrFail($request->storage_id);


        /*
        |--------------------------------------------------------------------------
        | IMAGE UPLOAD
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('expiry_image')) {

            $file = $request->file('expiry_image');

            $filename = 'expiry_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            $destination = public_path('uploads/images/product_expiry');

            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }

            $file->move($destination, $filename);

            $validated['expiry_image'] = 'uploads/images/product_expiry/' . $filename;
        }


        /*
        |--------------------------------------------------------------------------
        | CREATE EXPIRY RECORD
        |--------------------------------------------------------------------------
        */

        $validated['product_id'] = $storage->product_id;

        ProductExpiry::create($validated);


        /*
        |--------------------------------------------------------------------------
        | UPDATE STORAGE STATUS
        |--------------------------------------------------------------------------
        */

        $storage->update([
            'is_expired' => 1
        ]);


        return redirect()
            ->route('products_expirys.index')
            ->with('success', 'Product expiry recorded successfully');
    }


    /**
     * Show single record
     */
    public function show(string $id)
    {
        $expiry = ProductExpiry::with(['product', 'storage'])->findOrFail($id);

        return view(
            'backend.product_management.product_expiry.show',
            compact('expiry')
        );
    }


    /**
     * Show edit form
     */
    public function edit(string $id)
    {

        $productExpiry = ProductExpiry::findOrFail($id);

        $storages = Storage::with('product')->get();

        return view(
            'backend.product_management.product_expiry.edit',
            compact('productExpiry', 'storages')
        );
    }


    /**
     * Update expiry
     */
    public function update(Request $request, string $id)
    {

        $expiry = ProductExpiry::findOrFail($id);

        $validated = $request->validate([

            'storage_id' => 'required|exists:storages,id',

            'expired_qty' => 'required|integer|min:1',

            'expiry_description' => 'nullable|string',

            'error_solution' => 'nullable|string|max:255',

            'expiry_note' => 'nullable|string',

            'expiry_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120'

        ]);


        $storage = Storage::findOrFail($request->storage_id);


        /*
        |--------------------------------------------------------------------------
        | IMAGE UPDATE
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('expiry_image')) {

            if ($expiry->expiry_image && file_exists(public_path($expiry->expiry_image))) {
                unlink(public_path($expiry->expiry_image));
            }

            $file = $request->file('expiry_image');

            $filename = 'expiry_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            $destination = public_path('uploads/images/product_expiry');

            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }

            $file->move($destination, $filename);

            $validated['expiry_image'] = 'uploads/images/product_expiry/' . $filename;
        }


        /*
        |--------------------------------------------------------------------------
        | UPDATE RECORD
        |--------------------------------------------------------------------------
        */

        $validated['product_id'] = $storage->product_id;

        $expiry->update($validated);


        /*
        |--------------------------------------------------------------------------
        | UPDATE STORAGE STATUS
        |--------------------------------------------------------------------------
        */

        $storage->update([
            'is_expired' => 1
        ]);


        return redirect()
            ->route('products_expirys.index')
            ->with('success', 'Product expiry updated successfully');
    }


    /**
     * Delete expiry
     */
    public function destroy(string $id)
    {

        $expiry = ProductExpiry::findOrFail($id);

        $storage = Storage::find($expiry->storage_id);


        /*
        |--------------------------------------------------------------------------
        | DELETE IMAGE
        |--------------------------------------------------------------------------
        */

        if ($expiry->expiry_image && file_exists(public_path($expiry->expiry_image))) {
            unlink(public_path($expiry->expiry_image));
        }


        $expiry->delete();


        /*
        |--------------------------------------------------------------------------
        | RESET STORAGE FLAG
        |--------------------------------------------------------------------------
        */

        if ($storage) {

            $storage->update([
                'is_expired' => 0
            ]);
        }


        return redirect()
            ->route('products_expirys.index')
            ->with('success', 'Expiry record deleted successfully');
    }
}
