<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Manufacturer extends Model
{
    protected $fillable = [
        'name',
        'country',
        'email',
        'phone',
        'location',
        'is_active',
    ];

    public function storages()
    {
        return $this->hasMany(Storage::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->useLogName('Manufacturer')
            ->setDescriptionForEvent(fn(string $eventName) => "Manufacturer {$eventName}");
    }
}
