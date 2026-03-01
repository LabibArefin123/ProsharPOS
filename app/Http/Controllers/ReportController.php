<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Challan;
use App\Models\Supplier;

class ReportController extends Controller
{
    public function challanDaily(Request $request)
    {
        $query = Challan::with([
            'supplier',
            'branch',
            'citems',
        ]);

        // 🔹 Date filter (challan_date)
        if ($request->filled('from_date')) {
            $query->whereDate('challan_date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('challan_date', '<=', $request->to_date);
        }

        // 🔹 Supplier filter
        if ($request->filled('supplier_id')) {
            $query->where('supplier_id', $request->supplier_id);
        }

        // 🔹 Order latest first
        $challans = $query
            ->orderBy('challan_date', 'desc')
            ->get();

        // 🔹 Supplier list for filter dropdown
        $suppliers = Supplier::orderBy('name')->get();

        return view(
            'backend.report_management.transaction_management.challan.daily',
            compact('challans', 'suppliers')
        );
    }
}
