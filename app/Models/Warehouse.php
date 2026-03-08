<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    protected $fillable = [
        'name',
        'code',
        'location',
        'manager',
        'status',
        'created_by',
    ];

    public function storages()
    {
        return $this->hasMany(Storage::class);
    }
}
