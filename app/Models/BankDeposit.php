<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class BankDeposit extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'bank_balance_id',
        'user_id',
        'deposit_date',
        'amount',
        'amount_in_dollar',
        'deposit_method',
        'reference_no',
        'note',
    ];

    // Deposit belongs to BankBalance
    public function bankBalance()
    {
        return $this->belongsTo(BankBalance::class);
    }

    // Deposit added by User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->useLogName('Bank Deposit')
            ->setDescriptionForEvent(fn(string $eventName) => "Bank Deposit {$eventName}");
    }
}
