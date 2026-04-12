<?php

namespace App\Services;

use App\Models\QuizQuestion;
use App\Models\QuizTopic;
use App\Models\QuizUserProgress;
use App\Models\User;

class QuizService
{
    /**
     * Get the next question for a user in a specific topic.
     */
    public function getNextQuestion(QuizTopic $topic, User $user, string $mode = 'flashcard'): ?QuizQuestion
    {
        // 1. Get questions that are due for review (spaced repetition)
        $dueQuestion = QuizQuestion::where('quiz_topic_id', $topic->id)
            ->where('type', $mode)
            ->whereHas('userProgress', function ($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->where('next_review_at', '<=', now());
            })
            ->with(['userProgress' => function ($query) use ($user) {
                $query->where('user_id', $user->id);
            }])
            ->inRandomOrder()
            ->first();

        if ($dueQuestion) {
            return $dueQuestion;
        }

        // 2. Get new questions (never reviewed)
        $newQuestion = QuizQuestion::where('quiz_topic_id', $topic->id)
            ->where('type', $mode)
            ->whereDoesntHave('userProgress', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->inRandomOrder()
            ->first();

        return $newQuestion;
    }

    /**
     * Record progress for a question.
     */
    public function recordProgress(QuizQuestion $question, User $user, string $status): QuizUserProgress
    {
        $progress = QuizUserProgress::firstOrNew([
            'user_id' => $user->id,
            'quiz_question_id' => $question->id,
        ]);

        if (! $progress->exists) {
            $progress->ease_factor = 2.5;
        }

        $progress->status = $status;
        $progress->last_reviewed_at = now();
        $progress->review_count++;

        // Simple Spaced Repetition logic
        // If 'forgot', next review is soon (e.g., 1 day)
        // If 'known', next review is further away, increasing with review count
        if ($status === 'known') {
            $interval = $this->calculateInterval($progress->review_count, $progress->ease_factor);
            $progress->next_review_at = now()->addDays($interval);
            // Slightly increase ease factor if known
            $progress->ease_factor = min(3.5, $progress->ease_factor + 0.1);
        } else {
            // 'forgot' or 'incorrect'
            $progress->next_review_at = now()->addHours(12); // Review again in 12 hours
            // Decrease ease factor
            $progress->ease_factor = max(1.3, $progress->ease_factor - 0.2);
        }

        $progress->save();

        return $progress;
    }

    /**
     * Calculate next interval in days.
     */
    protected function calculateInterval(int $count, float $easeFactor): int
    {
        if ($count <= 1) {
            return 1;
        }
        if ($count == 2) {
            return 4;
        }

        return (int) round(($count - 1) * $easeFactor);
    }

    /**
     * Get statistics for a topic.
     */
    public function getTopicStats(QuizTopic $topic, User $user): array
    {
        $totalQuestions = $topic->questions()->count();
        $completedQuestions = QuizUserProgress::where('user_id', $user->id)
            ->whereIn('quiz_question_id', $topic->questions()->pluck('id'))
            ->where('status', 'known')
            ->count();

        return [
            'total' => $totalQuestions,
            'completed' => $completedQuestions,
            'percentage' => $totalQuestions > 0 ? round(($completedQuestions / $totalQuestions) * 100) : 0,
        ];
    }
}
