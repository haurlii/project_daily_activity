<?php

namespace App\Models;

use App\Enums\StatusTask;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Task extends Model
{
    protected $fillable = [
        'leader_id',
        'member_id',
        'title',
        'description',
        'start_date',
        'end_date',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'status' => StatusTask::class,
        ];
    }

    public function activity(): HasOne
    {
        return $this->hasOne(Activity::class, 'task_id');
    }

    public function leaderTask(): BelongsTo
    {
        return $this->belongsTo(User::class, 'leader_id');
    }

    public function memberTask(): BelongsTo
    {
        return $this->belongsTo(User::class, 'member_id');
    }
}
