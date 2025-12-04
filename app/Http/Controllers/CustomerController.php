<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::orderBy('id', 'asc')->get();;
        return view('people_management.customers.index', compact('customers'));
    }

    public function create()
    {
        return view('people_management.customers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|unique:customers,email',
            'phone_number' => 'required|string|max:20',
            'location'     => 'required|string|max:255',
        ]);

        Customer::create($request->all());

        return redirect()->route('customers.index')->with('success', 'Customer created successfully.');
    }

    public function show(Customer $customer)
    {
        return view('people_management.customers.show', compact('customer'));
    }

    public function edit(Customer $customer)
    {
        return view('people_management.customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'nullable|email|unique:customers,email,' . $customer->id,
            'phone_number' => 'nullable|string|max:20',
            'location'     => 'nullable|string|max:255',
        ]);

        $customer->update($request->all());

        return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('customers.index')->with('success', 'Customer deleted.');
    }
}
