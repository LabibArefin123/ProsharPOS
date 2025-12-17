<?php

namespace App\Http\Controllers\Backend\People_Management;
use App\Http\Controllers\Controller;
use App\Models\Manufacturer;
use Illuminate\Http\Request;

class ManufacturerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $manufacturers = Manufacturer::orderBy('id', 'asc')->get();
        return view('backend.people_management.manufacturers.index', compact('manufacturers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.people_management.manufacturers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string',
            'phone' => 'required|string|max:15',
            'location' => 'required|string',
            'country' => 'required|string',
        ]);

        Manufacturer::create($request->all());
        return redirect()->route('manufacturers.index')->with('success', 'Manufacturer created successfully.');
    }

    public function show(Manufacturer $manufacturer)
    {
        return view('backend.people_management.manufacturers.show', compact('manufacturer'));
    }

    public function edit(Manufacturer $manufacturer)
    {
        return view('backend.people_management.manufacturers.edit', compact('manufacturer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Manufacturer $manufacturer)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string',
            'phone' => 'required|string|max:15',
            'location' => 'required|string',
            'country' => 'required|string',
        ]);

        $manufacturer->update($request->all());
        return redirect()->route('manufacturers.index')->with('success', 'Manufacturer updated successfully.');
    }

    public function destroy(Manufacturer $manufacturer)
    {
        $manufacturer->delete();
        return redirect()->route('suppliers.index')->with('success', 'Manufacturer deleted.');
    }
}