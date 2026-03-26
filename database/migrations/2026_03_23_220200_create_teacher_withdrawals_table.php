<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teacher_withdrawals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->decimal('amount', 10, 2);
            $table->text('note')->nullable();
            $table->timestamp('withdrawn_at')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teacher_withdrawals');
    }
};
