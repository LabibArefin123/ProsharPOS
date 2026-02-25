<?php

namespace App\Http\Controllers\Backend\Setting_Management;

use App\Http\Controllers\Controller;
use App\Models\SystemInformation;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SystemInformationController extends Controller
{
    public function index()
    {
        $items = SystemInformation::all();
        return view('backend.setting_management.system_information.index', compact('items'));
    }

    public function create()
    {
        return view('backend.setting_management.system_information.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string',
            'title'       => 'required|string',
            'description' => 'nullable|string',
            'slogan'      => 'nullable|string',
            'photo'       => 'nullable|image|mimes:jpg,jpeg,png,webp',
        ]);

        $data = $request->except('photo');

        // file handling
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');

            // file name format: 1_hourminsec
            $filename = '1_' . Carbon::now()->format('His') . '.' . $file->getClientOriginalExtension();

            $file->move(public_path('upload/images/system_information'), $filename);

            $data['photo'] = $filename;
        }

        SystemInformation::create($data);

        return redirect()->route('system_informations.index')->with('success', 'Information added successfully');
    }

    public function show(SystemInformation $systemInformation)
    {
        return view('backend.setting_management.system_information.show', compact('systemInformation'));
    }

    public function edit(SystemInformation $systemInformation)
    {
        return view('backend.setting_management.system_information.edit', compact('systemInformation'));
    }

    public function update(Request $request, SystemInformation $systemInformation)
    {
        $request->validate([
            'name'        => 'required|string',
            'title'       => 'required|string',
            'description' => 'nullable|string',
            'slogan'      => 'nullable|string',
            'photo'       => 'nullable|image|mimes:jpg,jpeg,png,webp',
        ]);

        $data = $request->except('photo');

        // if new file uploaded
        if ($request->hasFile('photo')) {

            // delete old
            if ($systemInformation->photo && file_exists(public_path('uploads/images/system_information/' . $systemInformation->photo))) {
                unlink(public_path('uploads/images/system_information/' . $systemInformation->photo));
            }

            $file = $request->file('photo');
            $filename = '1_' . Carbon::now()->format('His') . '.' . $file->getClientOriginalExtension();

            $file->move(public_path('upload/images/system_information'), $filename);

            $data['photo'] = $filename;
        }

        $systemInformation->update($data);

        return redirect()->route('system_informations.index')->with('success', 'Information updated successfully');
    }

    public function destroy(SystemInformation $systemInformation)
    {
        if ($systemInformation->photo && file_exists(public_path('upload/system_information/' . $systemInformation->photo))) {
            unlink(public_path('upload/system_information/' . $systemInformation->photo));
        }

        $systemInformation->delete();

        return redirect()->route('system_informations.index')->with('success', 'Information deleted successfully');
    }
}
