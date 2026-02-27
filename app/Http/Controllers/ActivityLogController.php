<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use App\Models\User;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = Activity::with('causer')->latest();

        // Filter by User
        if ($request->user_id) {
            $query->where('causer_id', $request->user_id);
        }

        // Filter by Model
        if ($request->model) {
            $query->where('subject_type', $request->model);
        }

        // Filter by Date Range
        if ($request->from && $request->to) {
            $query->whereBetween('created_at', [
                $request->from . ' 00:00:00',
                $request->to . ' 23:59:59'
            ]);
        }

        // Search by Description
        if ($request->search) {
            $query->where('description', 'like', '%' . $request->search . '%');
        }

        $activities = $query->latest()->paginate(5)->withQueryString();

        $users = User::all();

        return view('backend.activity_logs.index', compact('activities', 'users'));
    }
}
