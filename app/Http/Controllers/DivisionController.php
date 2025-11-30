<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Division;
use Illuminate\Http\Request;

class DivisionController extends Controller
{
    /**
     * Display a listing of the guards.
     */
    public function index()
    {
        $divisions = Division::with('branch')->paginate(10);
        return view('department_menu.division.index', compact('divisions'));
    }

    /**
     * Show the form for creating a new guard.
     */
    public function create()
    {
        $branches = Branch::all();
        return view('department_menu.division.create', compact('branches'));
    }

    /**
     * Store a newly created guard in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'div_code' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|unique:branches,email',
            'address' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'contact_phone' => 'required|string|max:15',
        ]);

        Division::create($request->all());

        return redirect()->route('divisions.index')->with('success', 'Division added successfully!');
    }

    /**
     * Display the specified guard.
     */
    public function show(Division $division)
    {
        return view('department_menu.division.show', compact('division'));
    }

    /**
     * Show the form for editing the specified guard.
     */
    public function edit(Division $division)
    {
        $branches = Branch::all();
        return view('department_menu.division.edit', compact('division', 'branches'));
    }

    /**
     * Update the specified guard in storage.
     */
    public function update(Request $request, Division $division)
    {
        $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'div_code' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|unique:branches,email,' . $division->id,
            'address' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'contact_phone' => 'required|string|max:15',
        ]);

        $division->update($request->all());

        return redirect()->route('divisions.index')->with('success', 'Division updated successfully!');
    }

    /**
     * Remove the specified guard from storage.
     */
    public function destroy(Division $division)
    {
        $division->delete();
        return redirect()->route('divisions.index')->with('success', 'Division deleted successfully!');
    }
}
