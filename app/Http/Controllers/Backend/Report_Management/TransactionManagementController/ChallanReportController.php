<?php

namespace App\Http\Controllers\Backend\Report_Management\TransactionManagementController;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\Challan;
use App\Models\Supplier;

class ChallanReportController extends Controller
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

    public function challanDailyPdf(Request $request)
    {
        $query = Challan::with(['supplier', 'branch', 'citems']);

        if ($request->filled('from_date')) {
            $query->whereDate('challan_date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('challan_date', '<=', $request->to_date);
        }

        if ($request->filled('supplier_id')) {
            $query->where('supplier_id', $request->supplier_id);
        }

        $challans = $query
            ->orderBy('challan_date', 'desc')
            ->get();

        $pdf = Pdf::loadView(
            'backend.report_management.transaction_management.challan.daily_pdf',
            compact('challans')
        )->setPaper('a4', 'landscape');

        return $pdf->stream('challan-daily-report.pdf');
    }

    public function challanMonthly(Request $request)
    {
        $query = Challan::with(['supplier', 'branch', 'citems']);

        if ($request->filled('month')) {
            $query->whereMonth('challan_date', $request->month);
        }

        if ($request->filled('year')) {
            $query->whereYear('challan_date', $request->year);
        }

        if ($request->filled('supplier_id')) {
            $query->where('supplier_id', $request->supplier_id);
        }

        $challans = $query
            ->orderBy('challan_date', 'desc')
            ->get();

        $suppliers = Supplier::orderBy('name')->get();
        $years = range(2026, 2018);

        return view(
            'backend.report_management.transaction_management.challan.monthly',
            compact('challans', 'suppliers', 'years')
        );
    }

    public function challanMonthlyPdf(Request $request)
    {
        $query = Challan::with(['supplier', 'branch', 'citems']);

        if ($request->filled('month')) {
            $query->whereMonth('challan_date', $request->month);
        }

        if ($request->filled('year')) {
            $query->whereYear('challan_date', $request->year);
        }

        if ($request->filled('supplier_id')) {
            $query->where('supplier_id', $request->supplier_id);
        }

        $challans = $query
            ->orderBy('challan_date', 'desc')
            ->get();

        $pdf = Pdf::loadView(
            'backend.report_management.transaction_management.challan.monthly_pdf',
            compact('challans')
        )->setPaper('a4', 'landscape');

        return $pdf->stream('challan-monthly-report.pdf');
    }
}