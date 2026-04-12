<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuizUserProgress extends Model
{
    use HasFactory;

    protected $table = 'quiz_user_progress';

    protected $fillable = [
        'user_id',
        'quiz_question_id',
        'last_reviewed_at',
        'next_review_at',
        'status',
        'review_count',
        'ease_factor',
    ];

    protected $casts = [
        'last_reviewed_at' => 'datetime',
        'next_review_at' => 'datetime',
    ];

    public function question(): BelongsTo
    {
        return $this->belongsTo(QuizQuestion::class, 'quiz_question_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
