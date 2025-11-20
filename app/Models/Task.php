<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    protected $fillable = [
        'project_id',
        'title',
        'description',
        'due_date',
        'priority',
        'position',
        'is_completed'
    ];


    protected $casts = ['position' => 'integer'];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
