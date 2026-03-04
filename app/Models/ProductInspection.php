<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductInspection extends Model
{
    protected $fillable = [
        'storage_id',
        'user_id',
        'inspection_type',
        'status',
        'checked_quantity',
        'defective_quantity',
        'notes',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function storage()
    {
        return $this->belongsTo(Storage::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
