<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankDeposit extends Model
{
    use HasFactory;

    protected $fillable = [
        'bank_balance_id',
        'user_id',
        'deposit_date',
        'amount',
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
}
