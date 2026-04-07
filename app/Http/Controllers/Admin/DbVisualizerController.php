<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;

class DbVisualizerController extends Controller
{
    public function index()
    {
        return view('admin.dbv');
    }

    public function data(Request $request)
    {
        $search = $request->query('search');

        // Create internal request (no HTTP call)
        $internalRequest = Request::create('/dbv/data', 'GET', [
            'search' => $search
        ]);

        // Dispatch it inside Laravel
        $response = app()->handle($internalRequest);

        return response()->json(json_decode($response->getContent(), true));
    }
}
