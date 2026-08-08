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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate(); // الطالب
            $table->foreignId('subject_id')->constrained('subjects')->cascadeOnDelete()->cascadeOnUpdate();
            $table->boolean('status')->default(true);
            $table->string('period_type', 20)->default('term'); // term, month
            $table->unsignedTinyInteger('term_number')->nullable(); // 1,2,3...
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('payment_method', 50)->nullable();
            $table->string('payment_reference', 191)->nullable();
            $table->string('payment_phone', 30)->nullable();
            $table->enum('payment_status', ['pending', 'paid', 'rejected'])->default('pending');
            $table->decimal('amount_paid', 10, 2)->nullable();
            $table->string('payment_screenshot')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
