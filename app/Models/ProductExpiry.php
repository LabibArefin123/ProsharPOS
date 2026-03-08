<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductExpiry extends Model
{
    protected $fillable = [
        'storage_id',
        'product_id',
        'expired_qty',
        'expiry_description',
        'expiry_image',
        'error_solution',
        'expiry_note'
    ];

    public function storage()
    {
        return $this->belongsTo(Storage::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
