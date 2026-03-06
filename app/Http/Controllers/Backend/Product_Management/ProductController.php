<?php

namespace App\Http\Controllers\Backend\Product_Management;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Storage;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Unit;
use App\Models\Warranty;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'brand', 'unit', 'warranty']);

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->filled('sku')) {
            $query->where('sku', 'like', '%' . $request->sku . '%');
        }
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->filled('brand_id')) {
            $query->where('brand_id', $request->brand_id);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $products = $query->orderBy('id', 'asc')->get();

        return view('backend.product_management.products.index', compact('products'));
    }

    public function stock()
    {
        $products = Product::with([
            'category',
            'brand',
            'storage'
        ])->get();

        return view('backend.product_management.products.stock', compact('products'));
    }
    public function create()
    {
        $categories = Category::orderBy('name', 'asc')->get();
        $brands = Brand::orderBy('name', 'asc')->get();
        $units = Unit::orderBy('name', 'asc')->get();
        $warranties = Warranty::all();

        return view('backend.product_management.products.create', compact('categories', 'brands', 'units', 'warranties'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'               => 'required|string|max:255',
            'sku'               => 'required|string|max:255',
            'category_id'        => 'required|exists:categories,id',
            'brand_id'           => 'required|exists:brands,id',
            'unit_id'            => 'required|exists:units,id',
            'part_number'        => 'required|string|max:100',
            'type_model'         => 'required|string|max:100',
            'origin'             => 'required|string|max:100',
            'purchase_price'     => 'required|numeric',
            'handling_charge'    => 'nullable|numeric',
            'maintenance_charge' => 'nullable|numeric',
            'sell_price'         => 'required|numeric',
            'using_place'        => 'nullable|string',
            'description'        => 'nullable|string',
            'status'             => 'required|boolean',
            'warranty_id'        => 'required|exists:warranties,id',
        ]);

        Product::create($validated);

        return redirect()->route('products.index')->with('success', 'Product created successfully');
    }

    public function show(Product $product)
    {
        // eager load relations so show.blade.php doesn’t break
        $product->load(['category', 'brand', 'unit', 'warranty']);
        return view('backend.product_management.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $brands     = Brand::all();
        $units      = Unit::all();
        $warranties = Warranty::all();

        return view('backend.product_management.products.edit', compact('product', 'categories', 'brands', 'units', 'warranties'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name'               => 'required|string|max:255',
            'sku'               => 'required|string|max:255',
            'category_id'        => 'required|exists:categories,id',
            'brand_id'           => 'required|exists:brands,id',
            'unit_id'            => 'required|exists:units,id',
            'part_number'        => 'required|string|max:100',
            'type_model'         => 'required|string|max:100',
            'origin'             => 'required|string|max:100',
            'purchase_price'     => 'required|numeric',
            'handling_charge'    => 'nullable|numeric',
            'maintenance_charge' => 'nullable|numeric',
            'sell_price'         => 'required|numeric',
            'using_place'        => 'nullable|string',
            'description'        => 'nullable|string',
            'status'             => 'required|boolean',
            'warranty_id'        => 'required|exists:warranties,id',
        ]);

        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Product updated successfully');
    }

    public function destroy(Product $product)
    {
        // delete image if exists
        if ($product->image && file_exists(public_path($product->image))) {
            unlink(public_path($product->image));
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;

        if (!$ids) {
            return response()->json([
                'success' => false
            ]);
        }

        Product::whereIn('id', $ids)->delete();

        return response()->json([
            'success' => true
        ]);
    }

    public function bulkExport(Request $request)
    {
        $products = Product::whereIn('id', $request->ids)->get();

        $filename = "products_export_" . date('Ymd_His') . ".csv";

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
        ];

        $callback = function () use ($products) {

            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'ID',
                'Name',
                'Part Number',
                'SKU',
                'Category',
                'Brand',
                'Origin',
                'Status'
            ]);

            foreach ($products as $p) {

                fputcsv($file, [
                    $p->id,
                    $p->name,
                    $p->part_number,
                    $p->sku,
                    $p->category->name ?? '',
                    $p->brand->name ?? '',
                    $p->origin,
                    $p->status ? 'Active' : 'Inactive'
                ]);
            }

            fclose($file);
        };

        return new StreamedResponse($callback, 200, $headers);
    }
}
