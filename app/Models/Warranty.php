<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warranty extends Model
{
    protected $fillable = ['name', 'duration_type', 'day_count', 'description', 'created_by'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
