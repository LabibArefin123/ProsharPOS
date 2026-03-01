<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Backend\Report_Management\TransactionManagementController\ChallanReportController;

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
}
