<?php

namespace App\Http\Controllers\Backend\Product_Management;

use App\Http\Controllers\Controller;
use App\Models\Warranty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WarrantyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $warranties = Warranty::orderBy('id', 'asc')->get();
        return view('backend.product_management.warranties.index', compact('warranties'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.product_management.warranties.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'duration_type' => 'required|in:days,months,years',
            'day_count' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        Warranty::create([
            'name' => $request->name,
            'duration_type' => $request->duration_type,
            'day_count' => $request->day_count,
            'description' => $request->description,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('warranties.index')->with('success', 'Warranty created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $warranty = Warranty::findOrFail($id);
        return view('backend.product_management.warranties.show', compact('warranty'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $warranty = Warranty::findOrFail($id);
        return view('backend.product_management.warranties.edit', compact('warranty'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $warranty = Warranty::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:100',
            'duration_type' => 'required|in:days,months,years',
            'day_count' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        $warranty->update([
            'name' => $request->name,
            'duration_type' => $request->duration_type,
            'day_count' => $request->day_count,
            'description' => $request->description,
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('warranties.index')->with('success', 'Warranty updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $warranty = Warranty::findOrFail($id);
        $warranty->delete();

        return redirect()->route('warranties.index')->with('success', 'Warranty deleted successfully.');
    }
}
