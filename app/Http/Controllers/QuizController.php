<?php

namespace App\Http\Controllers;

use App\Http\Requests\RecordQuizProgressRequest;
use App\Models\QuizQuestion;
use App\Models\QuizTopic;
use App\Services\QuizService;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    protected $quizService;

    public function __construct(QuizService $quizService)
    {
        $this->quizService = $quizService;
    }

    /**
     * Display a listing of quiz topics.
     */
    public function index()
    {
        $topics = QuizTopic::all()->map(function ($topic) {
            $topic->stats = $this->quizService->getTopicStats($topic, Auth::user());

            return $topic;
        });

        return view('quizzes.index', compact('topics'));
    }

    /**
     * Show the specified topic's study/quiz options.
     */
    public function show(QuizTopic $topic)
    {
        $stats = $this->quizService->getTopicStats($topic, Auth::user());

        return view('quizzes.show', compact('topic', 'stats'));
    }

    /**
     * Study mode (Flashcards).
     */
    public function study(QuizTopic $topic)
    {
        $question = $this->quizService->getNextQuestion($topic, Auth::user(), 'flashcard');
        $stats = $this->quizService->getTopicStats($topic, Auth::user());

        if (! $question) {
            return redirect()->route('quizzes.show', $topic)
                ->with('message', 'Great job! You have reviewed all flashcards for this topic for now.');
        }

        return view('quizzes.study', compact('topic', 'question', 'stats'));
    }

    /**
     * Quiz mode (Multiple Choice).
     */
    public function quiz(QuizTopic $topic)
    {
        $question = $this->quizService->getNextQuestion($topic, Auth::user(), 'multiple_choice');
        $stats = $this->quizService->getTopicStats($topic, Auth::user());

        if (! $question) {
            return redirect()->route('quizzes.show', $topic)
                ->with('message', 'Excellent! You have completed all multiple-choice questions for this topic.');
        }

        return view('quizzes.quiz', compact('topic', 'question', 'stats'));
    }

    /**
     * Record progress for a question.
     */
    public function recordProgress(RecordQuizProgressRequest $request, QuizQuestion $question)
    {
        $this->quizService->recordProgress($question, Auth::user(), $request->status);

        // Redirect back to study/quiz for the next question
        $mode = $question->type === 'flashcard' ? 'study' : 'quiz';

        return redirect()->route('quizzes.'.$mode, $question->topic);
    }
}
