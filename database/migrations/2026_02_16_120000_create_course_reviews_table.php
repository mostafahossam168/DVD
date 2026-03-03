<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('course_reviews', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('subject_field', 100)->nullable()->comment('المادة مثل: فيزياء، رياضيات');
            $table->decimal('rating', 3, 1)->default(5)->comment('من 0 إلى 5');
            $table->text('review_text');
            $table->string('image')->nullable();
            $table->foreignId('subject_id')->nullable()->constrained('subjects')->nullOnDelete();
            $table->boolean('status')->default(true)->comment('مفعل للعرض في الفرونت');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_reviews');
    }
};
