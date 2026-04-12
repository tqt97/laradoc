<?php

namespace Database\Seeders;

use App\Models\QuizQuestion;
use App\Models\QuizTopic;
use Illuminate\Database\Seeder;

class QuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $phpTopic = QuizTopic::create([
            'name' => 'PHP Core',
            'slug' => 'php-core',
            'description' => 'Master the fundamentals of PHP, including OOP, traits, and type hinting.',
        ]);

        QuizQuestion::create([
            'quiz_topic_id' => $phpTopic->id,
            'question' => 'What is the difference between echo and print in PHP?',
            'short_answer' => 'echo has no return value and can take multiple parameters, while print has a return value of 1 and takes one argument.',
            'detailed_explanation' => 'echo is slightly faster than print because it does not return anything. echo can take multiple expressions (e.g., echo $a, $b;), whereas print can only take one. Both are language constructs, not functions.',
            'example' => "echo 'Hello', ' World'; // Valid\nprint 'Hello'; // Returns 1",
            'common_mistakes' => 'Thinking echo is a function and using parentheses unnecessarily, though they are allowed for single arguments.',
            'difficulty' => 'easy',
            'type' => 'flashcard',
        ]);

        QuizQuestion::create([
            'quiz_topic_id' => $phpTopic->id,
            'question' => 'What are Traits in PHP?',
            'short_answer' => 'A mechanism for code reuse in single inheritance languages like PHP.',
            'detailed_explanation' => 'Traits allow a developer to reuse sets of methods freely in several independent classes living in different class hierarchies. They are intended to reduce some limitations of single inheritance.',
            'example' => "trait Sharable {\n    public function share(\$item) { /* ... */ }\n}\n\nclass Post {\n    use Sharable;\n}",
            'difficulty' => 'medium',
            'type' => 'flashcard',
        ]);

        QuizQuestion::create([
            'quiz_topic_id' => $phpTopic->id,
            'question' => 'Which PHP function is used to get the length of a string?',
            'short_answer' => 'strlen()',
            'detailed_explanation' => 'strlen() returns the length of the given string on success, and 0 if the string is empty.',
            'difficulty' => 'easy',
            'type' => 'multiple_choice',
            'options' => [
                'A' => 'str_len()',
                'B' => 'strlen()',
                'C' => 'length()',
                'D' => 'count()',
            ],
            'correct_option' => 'B',
        ]);

        $laravelTopic = QuizTopic::create([
            'name' => 'Laravel Framework',
            'slug' => 'laravel',
            'description' => 'Deep dive into Laravel specific features like Eloquent, Middleware, and Service Containers.',
        ]);

        QuizQuestion::create([
            'quiz_topic_id' => $laravelTopic->id,
            'question' => 'What is Service Container in Laravel?',
            'short_answer' => 'A powerful tool for managing class dependencies and performing dependency injection.',
            'detailed_explanation' => 'The Laravel service container is a powerful tool for managing class dependencies and performing dependency injection. Dependency injection is a fancy phrase that essentially means: class dependencies are "injected" into the class via the constructor or, in some cases, "setter" methods.',
            'difficulty' => 'hard',
            'type' => 'flashcard',
        ]);
    }
}
