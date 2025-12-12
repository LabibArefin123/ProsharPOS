<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Challan;
use App\Models\ChallanItem;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $total_invoices = Invoice::count();
        $salesAmount = Invoice::sum('total');
        $receiveAmount = Invoice::sum('paid_amount');
        $totalPayment = Payment::sum('paid_amount');
        $totalPaymentInDollar = Payment::sum('dollar_amount');
        $dueAmount = Invoice::where('status', 0)
            ->selectRaw('SUM(total - paid_amount) as due')
            ->value('due');
        $total_challans = Challan::count();
        $total_challan_bill = ChallanItem::sum('challan_bill');
        $total_challan_unbill = ChallanItem::sum('challan_unbill');
        $total_challan_foc = ChallanItem::sum('challan_foc');

        return view('dashboard', compact(
            'total_invoices',
            'salesAmount',
            'receiveAmount',
            'dueAmount',
            'totalPayment',
            'totalPaymentInDollar',
            'total_challans',
            'total_challan_bill',
            'total_challan_unbill',
            'total_challan_foc'
        ));
    }
}
