<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class ProductDamage extends Model
{
    use LogsActivity;
    
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

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->useLogName('Product Damage')
            ->setDescriptionForEvent(fn(string $eventName) => "Product Damage {$eventName}");
    }
}