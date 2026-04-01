<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class ProductInspection extends Model
{
    use LogsActivity;
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

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->useLogName('Product Inspection')
            ->setDescriptionForEvent(fn(string $eventName) => "Product Inspection {$eventName}");
    }
}
