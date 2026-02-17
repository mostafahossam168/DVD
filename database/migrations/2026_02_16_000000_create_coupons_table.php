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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('type', ['percentage', 'fixed'])->default('percentage'); // نسبة مئوية أو مبلغ ثابت
            $table->decimal('value', 8, 2); // قيمة الخصم
            $table->decimal('min_amount', 8, 2)->nullable(); // الحد الأدنى للطلب
            $table->integer('usage_limit')->nullable(); // حد الاستخدام
            $table->integer('used_count')->default(0); // عدد مرات الاستخدام
            $table->date('start_date')->nullable(); // تاريخ البداية
            $table->date('end_date')->nullable(); // تاريخ النهاية
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
