<?php

namespace Database\Seeders;

use App\Models\QuizQuestion;
use App\Models\QuizTopic;
use Illuminate\Database\Seeder;

class QuizDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define Topics
        $topicsData = [
            [
                'name' => 'PHP Core & OOP',
                'slug' => 'php-core-oop',
                'description' => 'Essential PHP concepts, from basic syntax to object-oriented programming.',
            ],
            [
                'name' => 'Laravel Basic',
                'slug' => 'laravel-basic',
                'description' => 'Foundational Laravel: routing, controllers, migrations, and Eloquent.',
            ],
            [
                'name' => 'Laravel Core',
                'slug' => 'laravel-core',
                'description' => 'The inner workings: Service Container, Service Providers, and Middleware.',
            ],
            [
                'name' => 'Laravel Advanced',
                'slug' => 'laravel-advanced',
                'description' => 'Complex features: Queues, Jobs, Events, and Custom Service Bindings.',
            ],
            [
                'name' => 'Design Patterns',
                'slug' => 'design-patterns',
                'description' => 'Common architectural patterns in PHP and Laravel.',
            ],
            [
                'name' => 'JavaScript',
                'slug' => 'javascript',
                'description' => 'Core JS concepts: closures, prototypes, and async/await.',
            ],
            [
                'name' => 'React',
                'slug' => 'react',
                'description' => 'Modern React development: hooks, state, and component lifecycle.',
            ],
        ];

        foreach ($topicsData as $topicData) {
            $topic = QuizTopic::updateOrCreate(['slug' => $topicData['slug']], $topicData);
            $this->generateQuestionsForTopic($topic);
        }
    }

    private function generateQuestionsForTopic(QuizTopic $topic)
    {
        $questionsCount = 30;

        $pool = $this->getQuestionsPool($topic->slug);
        $poolSize = count($pool);

        for ($i = 0; $i < $questionsCount; $i++) {
            if ($i < $poolSize) {
                $questionData = $pool[$i];
            } else {
                $questionData = $this->getPlaceholderQuestion($topic, $i);
            }

            QuizQuestion::create(array_merge([
                'quiz_topic_id' => $topic->id,
                'type' => $questionData['type'] ?? (($i % 2 === 0) ? 'flashcard' : 'multiple_choice'),
                'difficulty' => $questionData['difficulty'] ?? (['easy', 'medium', 'hard'][rand(0, 2)]),
            ], $questionData));
        }
    }

    private function getQuestionsPool(string $slug): array
    {
        switch ($slug) {
            case 'php-core-oop':
                return [
                    [
                        'question' => 'What are the four pillars of OOP?',
                        'short_answer' => 'Encapsulation, Inheritance, Polymorphism, and Abstraction.',
                        'detailed_explanation' => 'Encapsulation hides internal state. Inheritance allows code reuse. Polymorphism allows different classes to be treated as instances of the same interface. Abstraction hides complex reality while only exposing relevant parts.',
                        'type' => 'flashcard',
                        'difficulty' => 'easy',
                    ],
                    [
                        'question' => 'What is the difference between an Interface and an Abstract Class?',
                        'short_answer' => 'Interfaces define a contract; Abstract classes provide a base for subclasses and can contain implemented methods.',
                        'detailed_explanation' => 'A class can implement multiple interfaces but extend only one abstract class. Abstract classes can have state (properties) while interfaces cannot.',
                        'type' => 'flashcard',
                        'difficulty' => 'medium',
                    ],
                    [
                        'question' => 'Which keyword is used to prevent a method from being overridden?',
                        'short_answer' => 'final',
                        'type' => 'multiple_choice',
                        'options' => ['A' => 'static', 'B' => 'const', 'C' => 'final', 'D' => 'protected'],
                        'correct_option' => 'C',
                        'detailed_explanation' => 'The final keyword prevents child classes from overriding a method. If used on a class, the class cannot be inherited.',
                    ],
                    [
                        'question' => 'What is Dependency Injection?',
                        'short_answer' => 'A design pattern where an object receives its dependencies from outside rather than creating them itself.',
                        'detailed_explanation' => 'DI promotes loose coupling and makes code easier to test. In PHP, it is usually done via the constructor.',
                        'example' => "class UserRepo { }\nclass UserController {\n    public function __construct(UserRepo \$repo) { ... }\n}",
                        'type' => 'flashcard',
                    ],
                    [
                        'question' => 'What is the purpose of the __construct() method?',
                        'short_answer' => 'It is the constructor called when a new instance of a class is created.',
                        'detailed_explanation' => 'The __construct method allows you to initialize an object\'s properties upon creation of the object.',
                        'type' => 'multiple_choice',
                        'options' => ['A' => 'To destroy an object', 'B' => 'To clone an object', 'C' => 'To initialize an object', 'D' => 'To serialize an object'],
                        'correct_option' => 'C',
                    ],
                ];
            case 'laravel-basic':
                return [
                    [
                        'question' => 'How do you define a route with a parameter?',
                        'short_answer' => 'Route::get(\'/user/{id}\', ...)',
                        'detailed_explanation' => 'Route parameters are always encased within curly braces and should consist of alphabetic characters.',
                        'example' => "Route::get('/user/{id}', function (\$id) {\n    return 'User '.\$id;\n});",
                        'type' => 'flashcard',
                    ],
                    [
                        'question' => 'What command is used to run migrations?',
                        'short_answer' => 'php artisan migrate',
                        'detailed_explanation' => 'The migrate Artisan command is used to run all of your outstanding migrations.',
                        'type' => 'multiple_choice',
                        'options' => ['A' => 'php artisan make:migration', 'B' => 'php artisan db:seed', 'C' => 'php artisan migrate', 'D' => 'php artisan migrate:rollback'],
                        'correct_option' => 'C',
                    ],
                    [
                        'question' => 'What is a Controller in Laravel?',
                        'short_answer' => 'A class that groups related request handling logic into a single class.',
                        'detailed_explanation' => 'Controllers are stored in the app/Http/Controllers directory and help keep your route files clean by moving logic out of closures.',
                        'type' => 'flashcard',
                    ],
                ];
            case 'laravel-core':
                return [
                    [
                        'question' => 'What is the Service Container?',
                        'short_answer' => 'A powerful tool for managing class dependencies and performing dependency injection.',
                        'detailed_explanation' => 'The service container is the heart of Laravel. It handles binding interfaces to concrete implementations and automatically resolves dependencies via reflection.',
                        'type' => 'flashcard',
                    ],
                    [
                        'question' => 'What is a Service Provider?',
                        'short_answer' => 'The central place to configure and bootstrap Laravel applications.',
                        'detailed_explanation' => 'Service providers are where you register bindings in the service container, listeners, middleware, and routes. Every provider has a register and a boot method.',
                        'type' => 'flashcard',
                    ],
                    [
                        'question' => 'What is Middleware?',
                        'short_answer' => 'A mechanism for filtering HTTP requests entering your application.',
                        'detailed_explanation' => 'Middleware provides a convenient mechanism for inspecting and filtering HTTP requests entering your application. For example, Laravel includes a middleware that verifies the user of your application is authenticated.',
                        'example' => "public function handle(\$request, Closure \$next)\n{\n    if (!\$request->user()) {\n        return redirect('login');\n    }\n    return \$next(\$request);\n}",
                        'type' => 'flashcard',
                    ],
                ];
        }

        return [];
    }

    private function getPlaceholderQuestion(QuizTopic $topic, int $index): array
    {
        $isMultipleChoice = ($index % 2 !== 0);
        $options = $isMultipleChoice ? [
            'A' => "Option A for {$topic->name} #{$index}",
            'B' => "Option B for {$topic->name} #{$index}",
            'C' => "Option C for {$topic->name} #{$index}",
            'D' => "Option D for {$topic->name} #{$index}",
        ] : null;

        return [
            'question' => "Advanced concept #{$index} in {$topic->name} topic?",
            'short_answer' => "Key takeaway #{$index} for mastering {$topic->name}.",
            'detailed_explanation' => "Detailed breakdown of concept #{$index}. This involves understanding the underlying architecture and how it integrates with other parts of the ecosystem.",
            'example' => "// Real-world example #{$index}\nfunction implementFeature() {\n    // Implementation logic for {$topic->name}\n    return true;\n}",
            'common_mistakes' => "Mistake #{$index}: Ignoring edge cases or performance implications.",
            'options' => $options,
            'correct_option' => $isMultipleChoice ? 'B' : null,
        ];
    }
}
