<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_parent', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('parent_id')->constrained('users')->onDelete('cascade');
            $table->unsignedBigInteger('class_id')->nullable(); // ✅ جعل الحقل class_id اختياريًا
            $table->unsignedBigInteger('school_id')->nullable(); // ✅ جعل الحقل school_id اختياريًا
            $table->timestamps();
            $table->engine = 'InnoDB';

            // ✅ منع التكرار لنفس العلاقة بين الطالب وولي الأمر
            $table->unique(['student_id', 'parent_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_parent');
    }
};
