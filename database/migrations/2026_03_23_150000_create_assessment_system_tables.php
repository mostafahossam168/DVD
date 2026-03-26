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
        Schema::create('question_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        Schema::create('question_bank_questions', function (Blueprint $table) {
            $table->id();
            $table->text('question_text');
            $table->enum('type', ['mcq', 'true_false', 'text']);
            $table->unsignedInteger('default_mark')->nullable();
            $table->enum('difficulty', ['easy', 'medium', 'hard'])->default('medium');
            $table->foreignId('teacher_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        Schema::create('question_bank_question_category', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained('question_bank_questions')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('category_id')->constrained('question_categories')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
            $table->unique(['question_id', 'category_id'], 'uq_qbq_category');
        });

        Schema::create('assessments', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->enum('type', ['exam', 'quiz', 'assignment']);
            $table->foreignId('teacher_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->dateTime('start_time')->nullable();
            $table->dateTime('end_time')->nullable();
            $table->unsignedInteger('duration')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        Schema::create('assessment_question', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_id')->constrained('assessments')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('question_id')->constrained('question_bank_questions')->cascadeOnDelete()->cascadeOnUpdate();
            $table->unsignedInteger('mark')->nullable();
            $table->unsignedInteger('order')->default(1);
            $table->timestamps();

            $table->unique(['assessment_id', 'question_id'], 'uq_assessment_question');
            $table->index(['assessment_id', 'order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessment_question');
        Schema::dropIfExists('assessments');
        Schema::dropIfExists('question_bank_question_category');
        Schema::dropIfExists('question_bank_questions');
        Schema::dropIfExists('question_categories');
    }
};
