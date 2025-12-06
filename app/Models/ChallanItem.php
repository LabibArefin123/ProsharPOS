<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChallanItem extends Model
{
    protected $fillable = [
        'challan_id',
        'product_id',
        'challan_total',
        'challan_bill',
        'challan_unbill',
        'challan_foc',
        'warranty_id',
    ];

    public function challan()
    {
        return $this->belongsTo(Challan::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function warranty()
    {
        return $this->belongsTo(Warranty::class);
    }
}
