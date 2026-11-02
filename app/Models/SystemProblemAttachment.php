<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SystemProblemAttachment extends Model
{
    protected $fillable = [
        'system_problem_id',
        'original_name',
        'file_path',
        'file_type',
        'file_size',
        'image_width',
        'image_height',
    ];

    public function problem(): BelongsTo
    {
        return $this->belongsTo(SystemProblem::class, 'system_problem_id');
    }
}
