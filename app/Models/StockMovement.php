<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class StockMovement extends Model
{
    use LogsActivity;
    protected $fillable = [
        'storage_id',
        'movement_type',
        'quantity',
        'reference_no',
        'note',
        'created_by'
    ];

    public function storage()
    {
        return $this->belongsTo(Storage::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->useLogName('Payment')
            ->setDescriptionForEvent(fn(string $eventName) => "Payment {$eventName}");
    }
}
