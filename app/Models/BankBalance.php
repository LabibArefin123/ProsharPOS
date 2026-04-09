<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class BankBalance extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'user_id',
        'balance',
        'balance_in_dollars',
        'currency',
    ];

    // Relationship to user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function deposits()
    {
        return $this->hasMany(BankDeposit::class);
    }

    public function withdraws()
    {
        return $this->hasMany(BankWithdraw::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->useLogName('Bank Balance')
            ->setDescriptionForEvent(fn(string $eventName) => "Bank Balance {$eventName}");
    }
}
