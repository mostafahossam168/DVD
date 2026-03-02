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
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->string('payment_method', 50)->nullable()->after('end_date');
            $table->string('payment_reference', 191)->nullable()->after('payment_method');
            $table->string('payment_phone', 30)->nullable()->after('payment_reference');
            $table->enum('payment_status', ['pending', 'paid', 'rejected'])
                ->default('pending')
                ->after('payment_phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropColumn(['payment_method', 'payment_reference', 'payment_phone', 'payment_status']);
        });
    }
};

