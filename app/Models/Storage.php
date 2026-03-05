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
        'minimum_stock_level',
        'maximum_stock_level',
        'reorder_quantity',
        'image_path',
        'is_active',
        'is_damaged',
        'damage_description',
        'damage_image',
        'damage_qty',
        'damage_solution',
        'is_expired',
        'expired_description',
        'expired_image',
        'expired_qty',
        'expired_solution',
        'barcode',
        'barcode_path',

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

    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }

    public function inspections()
    {
        return $this->hasMany(ProductInspection::class);
    }
}
