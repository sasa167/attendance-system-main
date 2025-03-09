<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name', 140);
            $table->foreignId('school_id')->constrained('schools')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('class_id')->nullable()->constrained('school_classes')->onUpdate('cascade')->onDelete('cascade');
            $table->string('class')->nullable(); // بدون `after`
            $table->foreignId('parent_id')->constrained('users')->onDelete('cascade'); // ✅ علاقة صحيحة مع users
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
