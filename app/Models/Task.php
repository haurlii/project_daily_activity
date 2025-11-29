<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    protected $fillable = [
        'leader_id',
        'member_id',
        'title',
        'description',
        'start_date',
        'end_date',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
        ];
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
