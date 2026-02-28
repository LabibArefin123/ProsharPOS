<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class SupplierPayment extends Model
{
    use LogsActivity;

    protected $fillable = [
        'payment_no',
        'supplier_id',
        'purchase_id',
        'amount',
        'payment_date',
        'payment_method',
        'note',
    ];

    protected $casts = [
        'payment_date' => 'date',
    ];

    // 🔥 Relationships
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    // 🔥 Activity Log
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['payment_no', 'supplier_id', 'amount', 'payment_date'])
            ->logOnlyDirty()
            ->useLogName('supplier_payment');
    }
}
