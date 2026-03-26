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
        Schema::table('question_bank_questions', function (Blueprint $table) {
            $table->foreignId('stage_id')->nullable()->after('teacher_id')->constrained('stages')->nullOnDelete()->cascadeOnUpdate();
            $table->foreignId('grade_id')->nullable()->after('stage_id')->constrained('grades')->nullOnDelete()->cascadeOnUpdate();
            $table->foreignId('subject_id')->nullable()->after('grade_id')->constrained('subjects')->nullOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('question_bank_questions', function (Blueprint $table) {
            $table->dropConstrainedForeignId('subject_id');
            $table->dropConstrainedForeignId('grade_id');
            $table->dropConstrainedForeignId('stage_id');
        });
    }
};
