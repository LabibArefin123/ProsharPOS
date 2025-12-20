<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Division;
use App\Models\Department;

class AjaxController extends Controller
{
    public function getDivisionByBranch(Request $request)
    {
        $branchId = $request->branch_id;

        $divisions = Division::where('branch_id', $branchId)
            ->select('id', 'name')
            ->orderBy('name', 'asc')
            ->get();

        return response()->json($divisions);
    }

    /**
     * Get departments by division.
     */
    public function getDepartmentByDivision(Request $request)
    {
        $divisionId = $request->division_id;

        $departments = Department::where('division_id', $divisionId)
            ->select('id', 'name')
            ->orderBy('name', 'asc')
            ->get();

        return response()->json($departments);
    }
}
