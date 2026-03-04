<?php

namespace App\Http\Controllers\Backend\Report_Management\TransactionManagementController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\Supplier;
use Barryvdh\DomPDF\Facade\Pdf;

class PurchaseReportController extends Controller
{
    // 🔹 Daily Report View
    public function purchaseDaily(Request $request)
    {
        $query = Purchase::with(['supplier', 'items.product']);

        if ($request->filled('from_date')) {
            $query->whereDate('purchase_date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('purchase_date', '<=', $request->to_date);
        }

        if ($request->filled('supplier_id')) {
            $query->where('supplier_id', $request->supplier_id);
        }

        $purchases = $query->orderBy('purchase_date', 'desc')->get();

        $suppliers = Supplier::orderBy('name')->get();

        return view(
            'backend.report_management.transaction_management.purchase.daily',
            compact('purchases', 'suppliers')
        );
    }

    // 🔹 Daily PDF
    public function purchaseDailyPdf(Request $request)
    {
        $query = Purchase::with(['supplier', 'items.product']);

        if ($request->filled('from_date')) {
            $query->whereDate('purchase_date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('purchase_date', '<=', $request->to_date);
        }

        if ($request->filled('supplier_id')) {
            $query->where('supplier_id', $request->supplier_id);
        }

        $purchases = $query->orderBy('purchase_date', 'desc')->get();

        $pdf = Pdf::loadView(
            'backend.report_management.transaction_management.purchase.daily_pdf',
            compact('purchases')
        )->setPaper('a4', 'landscape');

        return $pdf->stream('purchase-daily-report.pdf');
    }

    public function purchaseMonthly(Request $request)
    {
        $query = Purchase::with(['supplier', 'items.product']);

        if ($request->filled('month')) {
            $query->whereMonth('purchase_date', $request->month);
        }

        if ($request->filled('year')) {
            $query->whereYear('purchase_date', $request->year);
        }

        if ($request->filled('supplier_id')) {
            $query->where('supplier_id', $request->supplier_id);
        }

        $purchases = $query->orderBy('purchase_date', 'desc')->get();

        $suppliers = Supplier::orderBy('name')->get();
        $years = range(date('Y'), 2018); // You can adjust as needed

        return view(
            'backend.report_management.transaction_management.purchase.monthly',
            compact('purchases', 'suppliers', 'years')
        );
    }

    // 🔹 Monthly PDF
    public function purchaseMonthlyPdf(Request $request)
    {
        $query = Purchase::with(['supplier', 'items.product']);

        if ($request->filled('month')) {
            $query->whereMonth('purchase_date', $request->month);
        }

        if ($request->filled('year')) {
            $query->whereYear('purchase_date', $request->year);
        }

        if ($request->filled('supplier_id')) {
            $query->where('supplier_id', $request->supplier_id);
        }

        $purchases = $query->orderBy('purchase_date', 'desc')->get();

        $pdf = Pdf::loadView(
            'backend.report_management.transaction_management.purchase.monthly_pdf',
            compact('purchases')
        )->setPaper('a4', 'landscape');

        return $pdf->stream('purchase-monthly-report.pdf');
    }
}
