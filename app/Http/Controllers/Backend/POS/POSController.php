<?php

namespace App\Http\Controllers\Backend\POS;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Invoice;
use Illuminate\Http\Request;

class POSController extends Controller
{

    public function index()
    {
        $products = Product::with('storage')
            ->where('status', 1)
            ->get();

        $customers = Customer::all();

        return view('backend.pos.pos', compact('products', 'customers'));
    }
}
