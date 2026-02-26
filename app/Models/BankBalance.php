<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankBalance extends Model
{
    use HasFactory;

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
}
