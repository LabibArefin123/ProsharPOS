<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsletterSubscriber extends Model
{
    protected $table = 'newsletter_subscribers';

    protected $fillable = [
        'email',
        'ip_address',
        'country',
        'region',
        'city',
        'latitude',
        'longitude',
        'user_agent',
        'subscribed_at',
    ];

    public $timestamps = true;
}
