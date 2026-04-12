<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('quiz_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_topic_id')->constrained()->cascadeOnDelete();
            $table->text('question');
            $table->text('short_answer');
            $table->text('detailed_explanation');
            $table->text('example')->nullable();
            $table->text('common_mistakes')->nullable();
            $table->enum('difficulty', ['easy', 'medium', 'hard'])->default('medium');
            $table->json('tags')->nullable();
            $table->enum('type', ['flashcard', 'multiple_choice'])->default('flashcard');
            $table->json('options')->nullable(); // For multiple choice
            $table->string('correct_option')->nullable(); // For multiple choice
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_questions');
    }
};
