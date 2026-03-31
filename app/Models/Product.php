<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Product extends Model
{
    use SoftDeletes, LogsActivity;

    protected $fillable = [
        'name',
        'sku',
        'barcode',
        'barcode_path',
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

    public function damages()
    {
        return $this->hasMany(ProductDamage::class);
    }

    public function expiries()
    {
        return $this->hasMany(ProductExpiry::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->useLogName('Product')
            ->setDescriptionForEvent(fn(string $eventName) => "Product {$eventName}");
    }
}   
