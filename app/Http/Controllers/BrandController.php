<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::with('category')->orderBy('id', 'asc')->get();
        return view('backend.product_management.brands.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('backend.product_management.brands.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:brands,name',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
        ]);

        Brand::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('brands.index')->with('success', 'Brand created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $brand = Brand::with('category')->findOrFail($id);
        return view('backend.product_management.brands.show', compact('brand'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $brand = Brand::findOrFail($id);
        $categories = Category::all();
        return view('backend.product_management.brands.edit', compact('brand', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $brand = Brand::findOrFail($id);

        $request->validate([
            'name' => 'required|unique:brands,name,' . $brand->id,
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
        ]);

        $brand->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('brands.index')->with('success', 'Brand updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $brand = Brand::findOrFail($id);
        $brand->delete();

        return redirect()->route('brands.index')->with('success', 'Brand deleted successfully.');
    }
}
