<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory; // تضمين HasFactory بشكل صحيح

    protected $fillable = ['teacher_id', 'student_id', 'content'];

    // إذا كان اسم الجدول مختلفًا عن "notes"، أضفه هنا
    protected $table = 'notes';

    // تعطيل timestamps إذا لم تكن هناك حاجة إليها
    // public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); // تأكيد أن user_id هو المفتاح الصحيح
    }
}
