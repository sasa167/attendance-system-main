
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('parents', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique()->nullable(); // جعل البريد الإلكتروني اختياريًا
            $table->string('phone')->unique()->nullable(); // جعل الهاتف فريدًا ولكنه اختياري
            $table->timestamps();
            $table->engine = 'InnoDB';

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parents');
    }
};
