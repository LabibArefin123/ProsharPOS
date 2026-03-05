<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    protected $fillable = [
        'storage_id',
        'movement_type',
        'quantity',
        'reference_no',
        'note',
        'created_by'
    ];

    public function storage()
    {
        return $this->belongsTo(Storage::class);
    }
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
