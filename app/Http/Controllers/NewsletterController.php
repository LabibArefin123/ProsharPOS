<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NewsletterSubscriber;

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

        NewsletterSubscriber::create([
            'email' => $request->email,
            'subscribed_at' => now(),
        ]);

        return back()->with('success', 'Thanks for subscribing!');
    }
}
