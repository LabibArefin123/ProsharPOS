<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_id',
        'division_id',
        'dept_code',
        'name',
        'phone',
        'email',
        'address',
        'contact_person',
        'contact_phone',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function division()
    {
        return $this->belongsTo(Division::class, 'division_id');
    }
}
