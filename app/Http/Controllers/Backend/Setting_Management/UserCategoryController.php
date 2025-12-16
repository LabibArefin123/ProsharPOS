<?php

namespace App\Http\Controllers\Backend\Setting_Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserCategory;

class UserCategoryController extends Controller
{
    public function index()
    {
        $userCategories = UserCategory::orderBy('id', 'asc')->get();
        return view('backend.setting_management.user_category.index', compact('userCategories'));
    }

    public function create()
    {
        return view('backend.setting_management.user_category.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
            'category_name_in_bangla' => 'nullable|string|max:255',
            'description' => 'required|string',
        ]);

        UserCategory::create($request->all());

        return redirect()->route('user_categories.index')->with('success', 'User Category added successfully!');
    }

    public function show(UserCategory $userCategory)
    {
        return view('backend.setting_management.user_category.show', compact('userCategory'));
    }

    public function edit(UserCategory $userCategory)
    {
        return view('backend.setting_management.user_category.edit', compact('userCategory'));
    }

    public function update(Request $request, UserCategory $userCategory)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
            'category_name_in_bangla' => 'nullable|string|max:255',
            'description' => 'required|string',
        ]);

        $userCategory->update($request->all());

        return redirect()->route('user_categories.index')->with('success', 'User Category updated successfully!');
    }

    public function destroy(UserCategory $userCategory)
    {
        $userCategory->delete();
        return redirect()->route('user_categories.index')->with('success', 'User Category deleted successfully!');
    }
}
