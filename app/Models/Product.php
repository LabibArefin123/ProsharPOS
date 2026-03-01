<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'sku',
        'category_id',
        'brand_id',
        'unit_id',
        'part_number',
        'type_model',
        'origin',
        'purchase_price',
        'handling_charge',
        'maintenance_charge',
        'sell_price',
        'image',
        'using_place',
        'warranty_id',
        'description',
        'status',
    ];

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function warranty()
    {
        return $this->belongsTo(Warranty::class);
    }

    public function storage()
    {
        return $this->hasOne(Storage::class);
    }
}
