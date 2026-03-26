<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payment_methods', function (Blueprint $table) {
            $table->string('account_name')->nullable()->after('code');
            $table->string('account_number')->nullable()->after('account_name');
            $table->string('notes')->nullable()->after('account_number');
        });
    }

    public function down(): void
    {
        Schema::table('payment_methods', function (Blueprint $table) {
            $table->dropColumn(['account_name', 'account_number', 'notes']);
        });
    }
};
