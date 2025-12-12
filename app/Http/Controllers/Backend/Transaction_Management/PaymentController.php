<?php

namespace App\Http\Controllers\Backend\Transaction_Management;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Models\User;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['invoice', 'paidBy'])->orderBy('id', 'desc')->get();
        return view('transaction_management.payment.index', compact('payments'));
    }

    public function create()
    {
        $invoices = Invoice::where('status', 0)->get(); // pending invoices
        $users = User::all();
        return view('transaction_management.payment.create', compact('invoices', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'payment_name' => 'required|string',
            'invoice_id' => 'required|exists:invoices,id',
            'paid_amount' => 'required|numeric|min:0',
            'due_amount' => 'nullable|numeric|min:0',
            'paid_by' => 'required|exists:users,id',
            'payment_type' => 'required|string',
        ]);

        Payment::create([
            'payment_id' => rand(100000, 999999),
            'payment_name' => $request->payment_name,
            'invoice_id' => $request->invoice_id,
            'paid_amount' => $request->paid_amount,
            'due_amount' => $request->due_amount ?? 0,
            'paid_by' => $request->paid_by,
            'payment_type' => $request->payment_type,
        ]);

        // Update invoice if linked
        if ($request->invoice_id) {
            $invoice = Invoice::find($request->invoice_id);
            $invoice->paid_amount = $request->paid_amount;
            $invoice->paid_by = $request->paid_by;
            if ($request->paid_amount >= $invoice->total) {
                $invoice->status = 1; // mark paid
            } else {
                $invoice->status = 0; // partial paid
            }
            $invoice->save();
        }

        return redirect()->route('payments.index')->with('success', 'Payment recorded successfully');
    }

    public function show(Payment $payment)
    {
        return view('transaction_management.payment.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
        $invoices = Invoice::where('status', 0)->orWhere('id', $payment->invoice_id)->get();
        $users = User::all();
        return view('transaction_management.payment.edit', compact('payment', 'invoices', 'users'));
    }

    public function update(Request $request, Payment $payment)
    {
        $request->validate([
            'payment_name' => 'required|string',
            'invoice_id' => 'nullable|exists:invoices,id',
            'paid_amount' => 'required|numeric|min:0',
            'due_amount' => 'nullable|numeric|min:0',
            'paid_by' => 'required|exists:users,id',
            'payment_type' => 'required|string',
        ]);

        $payment->update([
            'payment_name' => $request->payment_name,
            'invoice_id' => $request->invoice_id,
            'paid_amount' => $request->paid_amount,
            'due_amount' => $request->due_amount ?? 0,
            'paid_by' => $request->paid_by,
            'payment_type' => $request->payment_type,
        ]);

        // Update invoice if linked
        if ($request->invoice_id) {
            $invoice = Invoice::find($request->invoice_id);
            $invoice->paid_amount = $request->paid_amount;
            $invoice->paid_by = $request->paid_by;
            if ($request->paid_amount >= $invoice->total) {
                $invoice->status = 1; // mark paid
            } else {
                $invoice->status = 0; // partial paid
            }
            $invoice->save();
        }

        return redirect()->route('payments.index')->with('success', 'Payment updated successfully');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();
        return redirect()->route('payments.index')->with('success', 'Payment deleted successfully');
    }
}
