<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    protected $fillable = [
        'payment_id',
        'payment_name',
        'invoice_id',
        'paid_amount',
        'due_amount',
        'paid_by',
        'payment_type'
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function paidBy()
    {
        return $this->belongsTo(User::class, 'paid_by');
    }
}
