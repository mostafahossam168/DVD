<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('online_meetings', function (Blueprint $table) {
            $table->foreignId('stage_id')->after('teacher_id')->nullable()->constrained('stages')->nullOnDelete();
            $table->foreignId('grade_id')->after('stage_id')->nullable()->constrained('grades')->nullOnDelete();
            $table->foreignId('subject_id')->after('grade_id')->nullable()->constrained('subjects')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('online_meetings', function (Blueprint $table) {
            $table->dropConstrainedForeignId('subject_id');
            $table->dropConstrainedForeignId('grade_id');
            $table->dropConstrainedForeignId('stage_id');
        });
    }
};

