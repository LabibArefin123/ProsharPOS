<?php

namespace App\Http\Controllers;

use App\Models\Invoice;

class CartController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with(['invoiceItems.product'])
            ->where('status', 'pending')
            ->orWhereColumn('paid_amount', '<', 'total')
            ->latest()
            ->get();

        return view('backend.cart.index', compact('invoices'));
    }
}
