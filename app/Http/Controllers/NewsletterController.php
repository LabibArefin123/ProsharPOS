<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NewsletterSubscriber;
use Illuminate\Support\Facades\Http;

class NewsletterController extends Controller
{
    public function index()
    {
        $subscribers = NewsletterSubscriber::latest()->paginate(15);

        return view('backend.setting_management.newsletter_subscriber.index', compact('subscribers'));
    }

    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:newsletter_subscribers,email',
        ]);

        $ip = $request->ip(); // real client IP
        $location = null;

        try {
            $response = Http::get("http://ip-api.com/json/{$ip}");

            if ($response->successful()) {
                $location = $response->json();
            }
        } catch (\Exception $e) {
            // silently fail – subscription must not break
        }

        NewsletterSubscriber::create([
            'email'       => $request->email,
            'ip_address'  => $ip,
            'country'     => $location['country'] ?? null,
            'region'      => $location['regionName'] ?? null,
            'city'        => $location['city'] ?? null,
            'latitude'    => $location['lat'] ?? null,
            'longitude'   => $location['lon'] ?? null,
            'user_agent'  => $request->userAgent(),
            'subscribed_at' => now(),
        ]);

        return back()->with('success', 'Thanks for subscribing!');
    }
}
