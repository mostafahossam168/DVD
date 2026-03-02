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
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->string('period_type', 20)->default('term')->after('status'); // term, month
            $table->unsignedTinyInteger('term_number')->nullable()->after('period_type'); // 1,2,3...
            $table->date('start_date')->nullable()->after('term_number');
            $table->date('end_date')->nullable()->after('start_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropColumn(['period_type', 'term_number', 'start_date', 'end_date']);
        });
    }
};

