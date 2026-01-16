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
        'start_date',
        'title',
        'description',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'status' => StatusTask::class,
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
