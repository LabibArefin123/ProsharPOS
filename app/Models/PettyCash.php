<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class PettyCash extends Model
{
    use LogsActivity;
    protected $fillable = [
        'bank_balance_id',
        'supplier_id',
        'customer_id',
        'category_id',
        'product_id',
        'user_id',
        'reference_no',
        'type',
        'reference_type',
        'amount',
        'amount_in_dollar',
        'exchange_rate',
        'currency',
        'payment_method',
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

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->useLogName('Petty Cash')
            ->setDescriptionForEvent(fn(string $eventName) => "Petty Cash {$eventName}");
    }
}
