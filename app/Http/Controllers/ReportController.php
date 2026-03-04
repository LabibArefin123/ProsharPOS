<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Backend\Report_Management\TransactionManagementController\ChallanReportController;
use App\Http\Controllers\Backend\Report_Management\TransactionManagementController\PurchaseReportController;
use App\Http\Controllers\Backend\Report_Management\TransactionManagementController\InvoiceReportController;

class ReportController extends Controller
{
    public function challanDaily(Request $request)
    {
        return app(ChallanReportController::class)->challanDaily($request);
    }

    public function challanDailyPdf(Request $request)
    {
        return app(ChallanReportController::class)->challanDailyPdf($request);
    }

    public function challanMonthly(Request $request)
    {
        return app(ChallanReportController::class)->challanMonthly($request);
    }

    public function challanMonthlyPdf(Request $request)
    {
        return app(ChallanReportController::class)->challanMonthlyPdf($request);
    }

    public function purchaseDaily(Request $request)
    {
        return app(PurchaseReportController::class)->purchaseDaily($request);
    }

    public function purchaseDailyPdf(Request $request)
    {
        return app(PurchaseReportController::class)->purchaseDailyPdf($request);
    }

    public function purchaseMonthly(Request $request)
    {
        return app(PurchaseReportController::class)->purchaseMonthly($request);
    }

    public function purchaseMonthlyPdf(Request $request)
    {
        return app(PurchaseReportController::class)->purchaseMonthlyPdf($request);
    }

    public function invoiceDaily(Request $request)
    {
        return app(InvoiceReportController::class)->invoiceDaily($request);
    }

    public function invoiceDailyPdf(Request $request)
    {
        return app(InvoiceReportController::class)->invoiceDailyPdf($request);
    }

    public function invoiceMonthly(Request $request)
    {
        return app(InvoiceReportController::class)->invoiceMonthly($request);
    }

    public function invoiceMonthlyPdf(Request $request)
    {
        return app(InvoiceReportController::class)->invoiceMonthlyPdf($request);
    }
}
