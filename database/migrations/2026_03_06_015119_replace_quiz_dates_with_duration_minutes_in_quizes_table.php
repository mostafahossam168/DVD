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
        Schema::table('quizes', function (Blueprint $table) {
            $table->unsignedSmallInteger('duration_minutes')->default(60)->after('lecture_id');
        });
        Schema::table('quizes', function (Blueprint $table) {
            $table->dropColumn(['start_time', 'end_time']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quizes', function (Blueprint $table) {
            $table->dateTime('start_time')->nullable();
            $table->dateTime('end_time')->nullable();
        });
        Schema::table('quizes', function (Blueprint $table) {
            $table->dropColumn('duration_minutes');
        });
    }
};
