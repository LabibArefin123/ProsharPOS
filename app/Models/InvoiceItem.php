<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    protected $fillable = [
        'invoice_id',
        'product_id',
        'quantity',
        'price',
        'discount',
        'amount',
    ];

    // Define the relationship back to Invoice
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    // Optionally, relationship to Product if you have a Product model
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
