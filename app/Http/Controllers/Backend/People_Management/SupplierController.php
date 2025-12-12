<?php

namespace App\Http\Controllers\Backend\People_Management;

use App\Http\Controllers\Controller;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::orderBy('id', 'asc')->get();
        return view('backend.people_management.suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('backend.people_management.suppliers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string',
            'company_name' => 'required|string',
            'company_number' => 'required|string',
            'phone_number' => 'required|string|max:15',
            'license_number' => 'required|string',
            'location' => 'required|string',
        ]);

        Supplier::create($request->all());
        return redirect()->route('suppliers.index')->with('success', 'Supplier created successfully.');
    }

    public function edit(Supplier $supplier)
    {
        return view('backend.people_management.suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string',
            'company_name' => 'required|string',
            'company_number' => 'required|string',
            'phone_number' => 'required|string|max:15',
            'license_number' => 'required|string',
            'location' => 'required|string',
        ]);

        $supplier->update($request->all());
        return redirect()->route('suppliers.index')->with('success', 'Supplier updated successfully.');
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return redirect()->route('suppliers.index')->with('success', 'Supplier deleted.');
    }
}
