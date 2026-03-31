<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class ProductExpiry extends Model
{
    use LogsActivity;
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

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->useLogName('Product Expiry')
            ->setDescriptionForEvent(fn(string $eventName) => "Product Expiry {$eventName}");
    }
}
