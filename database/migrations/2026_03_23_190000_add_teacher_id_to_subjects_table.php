<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('subjects', function (Blueprint $table) {
            $table->foreignId('teacher_id')->nullable()->after('grade_id')->constrained('users')->nullOnDelete()->cascadeOnUpdate();
        });

        $subjectTeacherRows = DB::table('subject_teachers')
            ->select('subject_id', DB::raw('MIN(teacher_id) as teacher_id'))
            ->groupBy('subject_id')
            ->get();

        foreach ($subjectTeacherRows as $row) {
            DB::table('subjects')->where('id', $row->subject_id)->update(['teacher_id' => $row->teacher_id]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subjects', function (Blueprint $table) {
            $table->dropConstrainedForeignId('teacher_id');
        });
    }
};
