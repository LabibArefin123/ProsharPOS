<?php

namespace App\Http\Controllers\Backend\Report_Management\TransactionManagementController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Customer;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceReportController extends Controller
{
    // 🔹 Daily Report View
    public function invoiceDaily(Request $request)
    {
        $query = Invoice::with(['customer', 'branch', 'invoiceItems.product']);

        if ($request->filled('from_date')) {
            $query->whereDate('invoice_date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('invoice_date', '<=', $request->to_date);
        }

        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }

        $invoices = $query->orderBy('invoice_date', 'desc')->get();
        $customers = Customer::orderBy('name')->get();

        return view('backend.report_management.transaction_management.invoice.daily', compact('invoices', 'customers'));
    }

    // 🔹 Daily PDF
    public function invoiceDailyPdf(Request $request)
    {
        $query = Invoice::with(['customer', 'branch', 'invoiceItems.product']);

        if ($request->filled('from_date')) {
            $query->whereDate('invoice_date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('invoice_date', '<=', $request->to_date);
        }

        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }

        $invoices = $query->orderBy('invoice_date', 'desc')->get();

        $pdf = Pdf::loadView('backend.report_management.transaction_management.invoice.daily_pdf', compact('invoices'))
            ->setPaper('a4', 'landscape');

        return $pdf->stream('invoice-daily-report.pdf');
    }

    // 🔹 Monthly Report View
    public function invoiceMonthly(Request $request)
    {
        $query = Invoice::with(['customer', 'branch', 'invoiceItems.product']);

        if ($request->filled('month')) {
            $query->whereMonth('invoice_date', $request->month);
        }

        if ($request->filled('year')) {
            $query->whereYear('invoice_date', $request->year);
        }

        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }

        $invoices = $query->orderBy('invoice_date', 'desc')->get();
        $customers = Customer::orderBy('name')->get();
        $years = range(date('Y'), 2018);

        return view('backend.report_management.transaction_management.invoice.monthly', compact('invoices', 'customers', 'years'));
    }

    // 🔹 Monthly PDF
    public function invoiceMonthlyPdf(Request $request)
    {
        $query = Invoice::with(['customer', 'branch', 'invoiceItems.product']);

        if ($request->filled('month')) {
            $query->whereMonth('invoice_date', $request->month);
        }

        if ($request->filled('year')) {
            $query->whereYear('invoice_date', $request->year);
        }

        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }

        $invoices = $query->orderBy('invoice_date', 'desc')->get();

        $pdf = Pdf::loadView('backend.report_management.transaction_management.invoice.monthly_pdf', compact('invoices'))
            ->setPaper('a4', 'landscape');

        return $pdf->stream('invoice-monthly-report.pdf');
    }
}
