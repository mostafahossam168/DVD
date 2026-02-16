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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quize_id')->constrained('quizes')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('question');
            $table->enum('type', ['text', 'mcq'])->default('text');
            $table->json('answers')->nullable();
            $table->string('correct_answer')->nullable();
            $table->integer('grade');
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
