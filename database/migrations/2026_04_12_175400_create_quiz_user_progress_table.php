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
        Schema::create('quiz_user_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('quiz_question_id')->constrained()->cascadeOnDelete();
            $table->dateTime('last_reviewed_at')->nullable();
            $table->dateTime('next_review_at')->nullable();
            $table->enum('status', ['known', 'forgot', 'incorrect'])->default('forgot');
            $table->integer('review_count')->default(0);
            $table->float('ease_factor')->default(2.5); // SM-2 starting ease factor
            $table->timestamps();

            $table->unique(['user_id', 'quiz_question_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_user_progress');
    }
};
