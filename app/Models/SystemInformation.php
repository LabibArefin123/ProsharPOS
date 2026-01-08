<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemInformation extends Model
{
    protected $table = 'system_informations';
    protected $fillable = [
        'name',
        'title',
        'description',
        'slogan',
        'photo'
    ];
}
