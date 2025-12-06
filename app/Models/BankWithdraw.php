<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankWithdraw extends Model
{
    use HasFactory;

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
}
