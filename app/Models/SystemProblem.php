<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SystemProblem extends Model
{
    protected $fillable = [
        'problem_uid',
        'problem_title',
        'problem_description',
        'status',
    ];

    public function attachments(): HasMany
    {
        return $this->hasMany(SystemProblemAttachment::class);
    }
}
