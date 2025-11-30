<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companies = Company::orderBy('id', 'asc')->get();
        return view('setting_management.company_profile.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('setting_management.company_profile.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'                  => 'required|unique:companies,name',
            'logo'                  => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'contact_number'        => 'required|string|max:20',
            'address'               => 'required|string|max:255',
            'shipping_charge_inside' => 'required|numeric',
            'shipping_charge_outside' => 'required|numeric',
            'currency_symbol'       => 'required|string|max:5',
        ]);

        $data = $request->except('logo');

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $fileName = time() . '.' . $request->logo->extension();
            $request->logo->move(public_path('uploads/images/setting_management/company_profile'), $fileName);
            $data['logo'] = $fileName;
        }

        Company::create($data);

        return redirect()->route('companies.index')->with('success', 'Company created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        return view('setting_management.company_profile.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company)
    {
        $request->validate([
            'name'                  => 'required|unique:companies,name,' . $company->id,
            'logo'                  => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'contact_number'        => 'required|string|max:20',
            'address'               => 'required|string|max:255',
            'shipping_charge_inside' => 'required|numeric',
            'shipping_charge_outside' => 'required|numeric',
            'currency_symbol'       => 'required|string|max:5',
        ]);

        $data = $request->except('logo');

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($company->logo && file_exists(public_path('uploads/images/setting_management/company_profile/' . $company->logo))) {
                unlink(public_path('uploads/images/setting_management/company_profile/' . $company->logo));
            }

            $fileName = time() . '.' . $request->logo->extension();
            $request->logo->move(public_path('uploads/images/setting_management/company_profile'), $fileName);
            $data['logo'] = $fileName;
        }

        $company->update($data);

        return redirect()->route('companies.index')->with('success', 'Company updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        // Delete logo file if exists
        if ($company->logo && file_exists(public_path('uploads/images/setting_management/company_profile/' . $company->logo))) {
            unlink(public_path('uploads/images/setting_management/company_profile/' . $company->logo));
        }

        $company->delete();

        return redirect()->route('companies.index')->with('success', 'Company deleted successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        return view('setting_management.company_profile.show', compact('company'));
    }
}
