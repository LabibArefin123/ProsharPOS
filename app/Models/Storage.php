<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Storage extends Model
{
    protected $fillable = [
        'product_id',
        'supplier_id',
        'manufacturer_id',
        'rack_number',
        'box_number',
        'rack_no',
        'box_no',
        'rack_location',
        'box_location',
        'alert_quantity',
        'stock_quantity',
        'image_path',
        'barcode_path',
        'is_active',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class);
    }
}
