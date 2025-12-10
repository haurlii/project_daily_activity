<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Activity extends Model
{
    protected $fillable = [
        'task_id',
        'user_id',
        'start_date',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
        ];
    }

    public function task(): BelongsTo
    {
        return $this->belongsTo(User::class, 'task_id');
    }

    public function memberActivity(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
