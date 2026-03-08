<?php

namespace App\Http\Controllers\Backend\Product_Management;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Milon\Barcode\DNS1D;
use App\Models\Storage;
use App\Models\Warehouse;
use App\Models\Manufacturer;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\ProductDamage;
use App\Models\ProductExpiry;
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
        $warehouses = Warehouse::orderBy('name', 'asc')->get();

        return view('backend.product_management.storage.create', compact(
            'suppliers',
            'manufacturers',
            'warehouses',
            'products'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id'                => 'required|exists:products,id',
            'supplier_id'               => 'required|exists:suppliers,id',
            'manufacturer_id'           => 'required|exists:manufacturers,id',
            'rack_number'               => 'required|string|max:100',
            'box_number'                => 'required|string|max:100',
            'rack_no'                   => 'required|string|max:100',
            'box_no'                    => 'required|string|max:100',
            'rack_location'             => 'required|string|max:100',
            'box_location'              => 'required|string|max:100',
            'stock_quantity'            => 'required|integer',
            'alert_quantity'            => 'required|integer',
            'minimum_stock_level'       => 'required|integer|min:0',
            'maximum_stock_level'       => 'required|integer|gt:minimum_stock_level',
            'image_path'                => 'nullable|image|max:5120',
        ]);

        // Handle uploaded image
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

        /*
    |--------------------------------------------------------------------------
    | Generate Barcode
    |--------------------------------------------------------------------------
    */

        $barcode = 'STK' . time(); // unique barcode number

        $barcodeGenerator = new DNS1D();

        $barcodeImage = $barcodeGenerator->getBarcodePNG($barcode, 'C128');

        $barcodeFolder = public_path('uploads/barcodes');

        if (!file_exists($barcodeFolder)) {
            mkdir($barcodeFolder, 0777, true);
        }

        $barcodeFileName = $barcode . '.png';

        file_put_contents(
            $barcodeFolder . '/' . $barcodeFileName,
            base64_decode($barcodeImage)
        );

        $validated['barcode'] = $barcode;
        $validated['barcode_path'] = 'uploads/barcodes/' . $barcodeFileName;

        Storage::create($validated);

        return redirect()
            ->route('storages.index')
            ->with('success', 'Storage created successfully with barcode');
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
        $warehouses = Warehouse::orderBy('name', 'asc')->get();
        return view('backend.product_management.storage.edit', compact(
            'storage',
            'suppliers',
            'products',
            'manufacturers',
            'warehouses'
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

            'rack_number' => 'required|string|max:100',
            'box_number'  => 'required|string|max:100',
            'rack_no'     => 'required|string|max:100',
            'box_no'      => 'required|string|max:100',

            'rack_location' => 'nullable|string|max:150',
            'box_location'  => 'nullable|string|max:150',

            'stock_quantity' => 'required|integer|min:0',
            'alert_quantity' => 'required|integer|min:0',

            'minimum_stock_level' => 'required|integer|min:0',
            'maximum_stock_level' => 'required|integer|gt:minimum_stock_level',

            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',

            'damage_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'expired_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        /*
    |--------------------------------------------------------------------------
    | MAIN STORAGE IMAGE
    |--------------------------------------------------------------------------
    */

        if ($request->hasFile('image_path')) {

            if ($storage->image_path && file_exists(public_path($storage->image_path))) {
                @unlink(public_path($storage->image_path));
            }

            $file = $request->file('image_path');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $destination = public_path('uploads/images/storage');

            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }

            $file->move($destination, $filename);

            $validated['image_path'] = 'uploads/images/storage/' . $filename;
        }

        /*
    |--------------------------------------------------------------------------
    | BARCODE GENERATION
    |--------------------------------------------------------------------------
    */

        if (!$storage->barcode) {

            $barcode = 'STK' . time();

            $barcodeGenerator = new DNS1D();
            $barcodeImage = $barcodeGenerator->getBarcodePNG($barcode, 'C128');

            $folder = public_path('uploads/barcodes');

            if (!file_exists($folder)) {
                mkdir($folder, 0777, true);
            }

            $file = $barcode . '.png';

            file_put_contents(
                $folder . '/' . $file,
                base64_decode($barcodeImage)
            );

            $validated['barcode'] = $barcode;
            $validated['barcode_path'] = 'uploads/barcodes/' . $file;
        }

        /*
    |--------------------------------------------------------------------------
    | UPDATE STORAGE
    |--------------------------------------------------------------------------
    */

        $storage->update($validated);

        /*
    |--------------------------------------------------------------------------
    | DAMAGE LOGIC
    |--------------------------------------------------------------------------
    */

        if ($request->is_damaged == 1) {

            $damageImage = null;

            if ($request->hasFile('damage_image')) {

                $file = $request->file('damage_image');
                $filename = 'damage_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $path = public_path('uploads/images/storage/damage');

                if (!file_exists($path)) {
                    mkdir($path, 0755, true);
                }

                $file->move($path, $filename);

                $damageImage = 'uploads/images/storage/damage/' . $filename;
            }

            ProductDamage::updateOrCreate(
                [
                    'storage_id' => $storage->id
                ],
                [
                    'product_id' => $request->product_id,
                    'damage_qty' => $request->damage_qty,
                    'damage_description' => $request->damage_description,
                    'damage_solution' => $request->damage_solution,
                    'damage_image' => $damageImage
                ]
            );

            /* Remove expiry if existed */
            ProductExpiry::where('storage_id', $storage->id)->delete();
        } else {

            ProductDamage::where('storage_id', $storage->id)->delete();
        }

        /*
    |--------------------------------------------------------------------------
    | EXPIRY LOGIC
    |--------------------------------------------------------------------------
    */

        if ($request->is_expired == 1) {

            $expiryImage = null;

            if ($request->hasFile('expired_image')) {

                $file = $request->file('expired_image');
                $filename = 'expired_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $path = public_path('uploads/images/storage/expired');

                if (!file_exists($path)) {
                    mkdir($path, 0755, true);
                }

                $file->move($path, $filename);

                $expiryImage = 'uploads/images/storage/expired/' . $filename;
            }

            ProductExpiry::updateOrCreate(
                [
                    'storage_id' => $storage->id
                ],
                [
                    'product_id' => $request->product_id,
                    'expired_qty' => $request->expired_qty,
                    'expiry_description' => $request->expired_description,
                    'error_solution' => $request->expired_solution,
                    'expiry_image' => $expiryImage
                ]
            );

            /* Remove damage if existed */
            ProductDamage::where('storage_id', $storage->id)->delete();
        } else {

            ProductExpiry::where('storage_id', $storage->id)->delete();
        }

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

    public function generateBarcode($id)
    {
        $storage = Storage::findOrFail($id);

        if ($storage->barcode_path) {
            return response()->json([
                'success' => true,
                'barcode' => $storage->barcode,
                'barcode_path' => $storage->barcode_path
            ]);
        }

        $barcode = 'STK' . time();

        $barcodeGenerator = new DNS1D();
        $barcodeImage = $barcodeGenerator->getBarcodePNG($barcode, 'C128');

        $folder = public_path('uploads/barcodes');

        if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }

        $file = $barcode . '.png';

        file_put_contents($folder . '/' . $file, base64_decode($barcodeImage));

        $storage->barcode = $barcode;
        $storage->barcode_path = 'uploads/barcodes/' . $file;
        $storage->save();

        return response()->json([
            'success' => true,
            'barcode' => $barcode,
            'barcode_path' => $storage->barcode_path
        ]);
    }
}
