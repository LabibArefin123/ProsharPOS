<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankCard extends Model
{
    use HasFactory;

    protected $fillable = [
        'bank_balance_id',
        'user_id',
        'payment_date',
        'card_type',
        'card_holder_name',
        'card_last_four',
        'amount',
        'amount_in_dollar',
        'reference_no',
        'note',
    ];

    public function bankBalance()
    {
        return $this->belongsTo(BankBalance::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
