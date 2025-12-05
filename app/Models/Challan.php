<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Challan extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'challan_no',
        'challan_date',
        'supplier_id',
        'product_id',
        'branch_id',
        'pdf_path',
        'challan_ref',
        'out_ref',
        'warranty_id',
        'warranty_period',
        'status',
        'valid_until',
        'note',

        // Challan type fields
        'challan_total',
        'challan_bill',
        'challan_unbill',
        'challan_foc',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function warranty()
    {
        return $this->belongsTo(Warranty::class);
    }

    // Virtual attribute for display
    public function getChallanTypeAttribute()
    {
        if ($this->challan_bill > 0) return 'Bill';
        if ($this->challan_unbill > 0) return 'Unbill';
        if ($this->challan_foc > 0) return 'FOC';
        return 'Mixed';
    }
}
