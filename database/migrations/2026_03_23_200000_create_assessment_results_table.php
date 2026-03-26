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
        Schema::create('assessment_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('assessment_id')->constrained('assessments')->cascadeOnDelete()->cascadeOnUpdate();
            $table->unsignedInteger('score')->default(0);
            $table->unsignedInteger('max_score')->default(0);
            $table->json('details')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();
            $table->unique(['user_id', 'assessment_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessment_results');
    }
};
