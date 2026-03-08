<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductDamage extends Model
{
    protected $fillable = [
        'storage_id',
        'product_id',
        'damage_qty',
        'damage_description',
        'damage_image',
        'damage_solution',
        'damage_note'
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