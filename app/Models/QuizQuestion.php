<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuizQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_topic_id',
        'question',
        'short_answer',
        'detailed_explanation',
        'example',
        'common_mistakes',
        'difficulty',
        'tags',
        'type',
        'options',
        'correct_option',
    ];

    protected $casts = [
        'tags' => 'array',
        'options' => 'array',
    ];

    public function topic(): BelongsTo
    {
        return $this->belongsTo(QuizTopic::class, 'quiz_topic_id');
    }

    public function userProgress(): HasMany
    {
        return $this->hasMany(QuizUserProgress::class);
    }
}
