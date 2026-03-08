<?php

namespace App\Http\Controllers\Backend\Product_Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Warehouse;
use Illuminate\Support\Facades\Auth;

class WarehouseController extends Controller
{
    public function index()
    {
        $warehouses = Warehouse::latest()->get();
        return view('backend.product_management.warehouses.index', compact('warehouses'));
    }

    public function create()
    {
        return view('backend.product_management.warehouses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:100|unique:warehouses,code',
        ]);

        Warehouse::create([
            'name' => $request->name,
            'code' => $request->code,
            'location' => $request->location,
            'manager' => $request->manager,
            'status' => $request->status ? 1 : 0,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('warehouses.index')
            ->with('success', 'Warehouse created successfully.');
    }

    public function show($id)
    {
        $warehouse = Warehouse::findOrFail($id);
        return view('backend.product_management.warehouses.show', compact('warehouse'));
    }

    public function edit($id)
    {
        $warehouse = Warehouse::findOrFail($id);
        return view('backend.product_management.warehouses.edit', compact('warehouse'));
    }

    public function update(Request $request, $id)
    {
        $warehouse = Warehouse::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:100|unique:warehouses,code,' . $warehouse->id,
        ]);

        $warehouse->update([
            'name' => $request->name,
            'code' => $request->code,
            'location' => $request->location,
            'manager' => $request->manager,
            'status' => $request->status ? 1 : 0,
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('warehouses.index')
            ->with('success', 'Warehouse updated successfully.');
    }

    public function destroy($id)
    {
        $warehouse = Warehouse::findOrFail($id);
        $warehouse->delete();

        return redirect()->route('warehouses.index')
            ->with('success', 'Warehouse deleted successfully.');
    }
}
