<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('stage_id')->nullable()->after('type')->constrained()->nullOnDelete();
            $table->foreignId('grade_id')->nullable()->after('stage_id')->constrained()->nullOnDelete();
            $table->enum('study_mode', ['online', 'offline', 'hybrid'])->nullable()->after('grade_id');
        });

        Schema::create('monthly_fee_rules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grade_id')->constrained()->cascadeOnDelete();
            $table->foreignId('subject_id')->nullable()->constrained()->cascadeOnDelete();
            $table->decimal('amount', 10, 2);
            $table->unsignedTinyInteger('due_day')->default(10);
            $table->date('starts_on');
            $table->date('ends_on')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('student_monthly_invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('grade_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('subject_id')->nullable()->constrained()->nullOnDelete();
            $table->date('billing_month');
            $table->date('due_date');
            $table->decimal('amount_due', 10, 2);
            $table->decimal('amount_paid', 10, 2)->default(0);
            $table->enum('status', ['unpaid', 'partial', 'paid', 'cancelled'])->default('unpaid');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->unique(['student_id', 'subject_id', 'billing_month'], 'monthly_invoice_unique');
        });

        Schema::create('student_invoice_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_monthly_invoice_id')->constrained()->cascadeOnDelete();
            $table->foreignId('payment_method_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('received_by')->nullable()->constrained('users')->nullOnDelete();
            $table->decimal('amount', 10, 2);
            $table->timestamp('paid_at');
            $table->string('reference')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_invoice_payments');
        Schema::dropIfExists('student_monthly_invoices');
        Schema::dropIfExists('monthly_fee_rules');
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('grade_id');
            $table->dropConstrainedForeignId('stage_id');
            $table->dropColumn('study_mode');
        });
    }
};
