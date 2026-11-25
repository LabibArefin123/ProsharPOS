<?php

namespace App\Http\Controllers\Backend\POS;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Http\Request;

class POSController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with('storage')
            ->where('status', 1)
            ->latest()
            ->paginate(30)
            ->withQueryString();

        $customers = Customer::orderBy('name')->get();

        return view('backend.pos.pos', compact(
            'products',
            'customers'
        ));
    }
}
