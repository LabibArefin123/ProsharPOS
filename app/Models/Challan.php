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
        'customer_id',
        'product_id',
        'branch_id',
        'quantity',
        'pdf_path',
        'challan_ref',
        'out_ref',
        'warranty_id',
        'warranty_period',
        'serial_no',
        'status',
        'valid_until',
        'note',
    ];

    // Relationships (assuming you have these models)
    public function customer()
    {
        return $this->belongsTo(Customer::class);
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

       public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
