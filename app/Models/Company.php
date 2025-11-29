<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name',
        'logo',
        'address',
        'email',
        'contact_number',
        'shipping_charge_inside',
        'shipping_charge_outside',
        'currency_symbol',
    ];
}
