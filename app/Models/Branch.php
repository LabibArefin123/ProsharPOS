<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'balance',
        'city',
        'post_code',
        'address',
        'phone_number',
        'alternate_number',
        'email',
    ];
}
