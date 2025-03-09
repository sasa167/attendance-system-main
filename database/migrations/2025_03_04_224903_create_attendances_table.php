
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('student_id'); // تأكد من إضافته مرة واحدة فقط
            $table->date('date');
            $table->enum('status', ['present', 'absent', 'late']);
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('student_id'); // إنشاء العمود كـ BIGINT
            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade'); // إضافة المفتاح الأجنبي

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
