<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class BankWithdraw extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'bank_balance_id',
        'user_id',
        'withdraw_date',
        'amount',
        'withdraw_method',
        'reference_no',
        'note',
    ];

    // Withdraw belongs to BankBalance
    public function bankBalance()
    {
        return $this->belongsTo(BankBalance::class);
    }

    // Withdraw done by User\
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->useLogName('Bank Withdraw')
            ->setDescriptionForEvent(fn(string $eventName) => "Bank Withdraw {$eventName}");
    }
}
