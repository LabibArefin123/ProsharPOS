<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Challan;
use App\Models\Payment;

class DashboardController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function index()
    {
        $total_invoices = Invoice::count();
        $salesAmount = Invoice::sum('total');
        $receiveAmount = Invoice::sum('paid_amount');
        $totalPayment = Payment::sum('paid_amount');
        $dueAmount = Invoice::where('status', 0)
            ->selectRaw('SUM(total - paid_amount) as due')
            ->value('due');
        $total_challans = Challan::count();
        $total_challan_bill = Challan::sum('challan_bill'); // adjust 'type' and value if needed
        $total_challan_unbill = Challan::sum('challan_unbill'); // adjust as needed
        $total_challan_foc = Challan::sum('challan_foc'); // adjust as needed

        return view('dashboard', compact(
            'total_invoices',
            'salesAmount',
            'receiveAmount',
            'dueAmount',
            'totalPayment',
            'total_challans',
            'total_challan_bill',
            'total_challan_unbill',
            'total_challan_foc'
        ));
    }
}
