<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    /**
     * Display a listing of the guards.
     */
    public function index()
    {
        $branches = Branch::latest()->paginate(10);
        return view('department_menu.branch.index', compact('branches'));
    }

    /**
     * Show the form for creating a new guard.
     */
    public function create()
    {
        return view('department_menu.branch.create');
    }

    /**
     * Store a newly created guard in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'branch_code' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|unique:branches,email',
            'address' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'contact_phone' => 'required|string|max:15',
        ]);

        Branch::create($request->all());

        return redirect()->route('branches.index')->with('success', 'Branch added successfully!');
    }

    /**
     * Display the specified guard.
     */
    public function show(Branch $branch)
    {
        return view('department_menu.branch.show', compact('branch'));
    }

    /**
     * Show the form for editing the specified guard.
     */
    public function edit(Branch $branch)
    {
        return view('department_menu.branch.edit', compact('branch'));
    }

    /**
     * Update the specified guard in storage.
     */
    public function update(Request $request, Branch $branch)
    {
        $request->validate([
            'branch_code' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|unique:branches,email,' . $branch->id,
            'address' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'contact_phone' => 'required|string|max:15',
        ]);

        $branch->update($request->all());

        return redirect()->route('branches.index')->with('success', 'Branch updated successfully!');
    }

    /**
     * Remove the specified guard from storage.
     */
    public function destroy(Branch $branch)
    {
        $branch->delete();
        return redirect()->route('branches.index')->with('success', 'Branch deleted successfully!');
    }
}
