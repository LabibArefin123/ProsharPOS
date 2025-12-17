<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Manufacturer extends Model
{
    protected $fillable = [
        'name',
        'country',
        'email',
        'phone',
        'location',
        'is_active',
    ];

    public function storages()
    {
        return $this->hasMany(Storage::class);
    }
}
