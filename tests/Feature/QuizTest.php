<?php

namespace Tests\Feature;

use App\Models\QuizQuestion;
use App\Models\QuizTopic;
use App\Models\QuizUserProgress;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuizTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected $topic;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->topic = QuizTopic::create([
            'name' => 'PHP Core',
            'slug' => 'php-core',
            'description' => 'PHP Core Test',
        ]);
    }

    public function test_user_can_access_quiz_index()
    {
        $response = $this->actingAs($this->user)->get(route('quizzes.index'));

        $response->assertStatus(200);
        $response->assertSee('PHP Core');
    }

    public function test_user_can_get_study_question()
    {
        $question = QuizQuestion::create([
            'quiz_topic_id' => $this->topic->id,
            'question' => 'What is echo?',
            'short_answer' => 'echo is used for output',
            'detailed_explanation' => 'Detailed explanation of echo',
            'type' => 'flashcard',
        ]);

        $response = $this->actingAs($this->user)->get(route('quizzes.study', $this->topic));

        $response->assertStatus(200);
        $response->assertSee('What is echo?');
    }

    public function test_user_can_record_progress_known()
    {
        $question = QuizQuestion::create([
            'quiz_topic_id' => $this->topic->id,
            'question' => 'What is echo?',
            'short_answer' => 'echo is used for output',
            'detailed_explanation' => 'Detailed explanation of echo',
            'type' => 'flashcard',
        ]);

        $response = $this->actingAs($this->user)->post(route('quizzes.progress', $question), [
            'status' => 'known',
        ]);

        $response->assertRedirect(route('quizzes.study', $this->topic));

        $progress = QuizUserProgress::where('user_id', $this->user->id)
            ->where('quiz_question_id', $question->id)
            ->first();

        $this->assertNotNull($progress);
        $this->assertEquals('known', $progress->status);
        $this->assertEquals(1, $progress->review_count);
        $this->assertNotNull($progress->next_review_at);
        $this->assertTrue($progress->next_review_at->isFuture());
    }

    public function test_user_can_record_progress_forgot()
    {
        $question = QuizQuestion::create([
            'quiz_topic_id' => $this->topic->id,
            'question' => 'What is echo?',
            'short_answer' => 'echo is used for output',
            'detailed_explanation' => 'Detailed explanation of echo',
            'type' => 'flashcard',
        ]);

        $response = $this->actingAs($this->user)->post(route('quizzes.progress', $question), [
            'status' => 'forgot',
        ]);

        $progress = QuizUserProgress::where('user_id', $this->user->id)
            ->where('quiz_question_id', $question->id)
            ->first();

        $this->assertEquals('forgot', $progress->status);
        // Next review for 'forgot' should be in 12 hours (soon)
        $this->assertTrue($progress->next_review_at->isAfter(now()->addHours(11)));
    }

    public function test_user_gets_no_question_if_none_due()
    {
        $question = QuizQuestion::create([
            'quiz_topic_id' => $this->topic->id,
            'question' => 'What is echo?',
            'short_answer' => 'echo is used for output',
            'detailed_explanation' => 'Detailed explanation of echo',
            'type' => 'flashcard',
        ]);

        // Mark as known
        $this->actingAs($this->user)->post(route('quizzes.progress', $question), [
            'status' => 'known',
        ]);

        // Attempt to get study question again
        $response = $this->actingAs($this->user)->get(route('quizzes.study', $this->topic));

        $response->assertRedirect(route('quizzes.show', $this->topic));
        $response->assertSessionHas('message');
    }
}
