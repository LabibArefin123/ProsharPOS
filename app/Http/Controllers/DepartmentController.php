<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Division;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the guards.
     */
    public function index()
    {
        $departments = Department::with(['branch', 'division'])->paginate(10);
        return view('department_menu.department.index', compact('departments'));
    }

    /**
     * Show the form for creating a new guard.
     */
    public function create()
    {
        $branches = Branch::all();
        return view('department_menu.department.create', compact('branches'));
    }

    /**
     * Store a newly created guard in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'division_id' => 'required|exists:divisions,id',
            'dept_code' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|email',
            'address' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'contact_phone' => 'required|string|max:15',
        ]);

        Department::create($request->all());

        return redirect()->route('departments.index')->with('success', 'Department added successfully!');
    }

    /**
     * Display the specified guard.
     */
    public function show(Department $department)
    {
        return view('department_menu.department.show', compact('department'));
    }

    /**
     * Show the form for editing the specified guard.
     */
    public function edit(Department $department)
    {
        $branches = Branch::all();
        return view('department_menu.department.edit', compact('department', 'branches'));
    }

    /**
     * Update the specified guard in storage.
     */
    public function update(Request $request, Department $department)
    {
        $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'division_id' => 'required|exists:divisions,id',
            'dept_code' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|unique:branches,email,' . $department->id,
            'address' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'contact_phone' => 'required|string|max:15',
        ]);

        $department->update($request->all());

        return redirect()->route('departments.index')->with('success', 'Department updated successfully!');
    }

    /**
     * Remove the specified guard from storage.
     */
    public function destroy(Department $department)
    {
        $department->delete();
        return redirect()->route('departments.index')->with('success', 'Department deleted successfully!');
    }
}
