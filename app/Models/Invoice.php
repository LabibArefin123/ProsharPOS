<?php

// app/Models/Invoice.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Invoice extends Model
{
    use LogsActivity;
    protected $fillable = [
        'invoice_id',
        'customer_id',
        'branch_id',
        'invoice_date',
        'status',
        'items',
        'discount_type',
        'discount_value',
        'sub_total',
        'paid_by',
        'paid_amount',
        'dollar_amount',
        'total'
    ];

    protected $casts = [
        'items' => 'array',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function invoiceItems()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function paidByUser()
    {
        return $this->belongsTo(User::class, 'paid_by');
    }

    public function salesReturns()
    {
        return $this->hasMany(SalesReturn::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->useLogName('Invoice')
            ->setDescriptionForEvent(fn(string $eventName) => "Invoice {$eventName}");
    }
}
