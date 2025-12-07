<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PettyCash extends Model
{
    protected $fillable = [
        'bank_balance_id',
        'supplier_id',
        'customer_id',
        'user_id',
        'reference_no',
        'type',
        'reference_type',
        'item_name',
        'amount',
        'amount_in_dollar',
        'exchange_rate',
        'currency',
        'payment_method',
        'category',
        'note',
        'attachment',
        'status',
    ];

    // PettyCash belongs to one BankBalance
    public function bankBalance()
    {
        return $this->belongsTo(BankBalance::class, 'bank_balance_id');
    }

    // PettyCash belongs to one Supplier
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    // PettyCash belongs to one Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    // PettyCash belongs to one User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
