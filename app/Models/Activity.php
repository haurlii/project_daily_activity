<?php

namespace App\Models;

use App\Enums\StatusTask;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Activity extends Model
{
    protected $fillable = [
        'task_id',
        'user_id',
        'title',
        'description',
        'started_at',
        'completed_at',
        'status',
        'confirmed',
    ];

    protected function casts(): array
    {
        return [
            'started_at' => 'datetime',
            'completed_at' => 'datetime',
            'status' => StatusTask::class,
            'confirmed' => 'boolean',
        ];
    }

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class, 'task_id');
    }

    public function memberActivity(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
