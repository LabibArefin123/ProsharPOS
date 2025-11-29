<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Challan;

class DashboardController extends Controller
{
    public function index()
    {

        $total_challans = Challan::count();
        $total_challan_bill = Challan::where('status', 'bill')->count(); // adjust 'type' and value if needed
        $total_challan_unbill = Challan::where('status', 'unbill')->count(); // adjust as needed

        return view('dashboard', compact('total_challans', 'total_challan_bill', 'total_challan_unbill'));
    }
}
