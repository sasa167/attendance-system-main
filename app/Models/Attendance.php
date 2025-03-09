<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    protected $table = 'attendances';
    protected $fillable = ['date', 'status', 'student_id','notes'];

    // لو الجدول اسمه مختلف عن `attendances`، أضفه هنا
    // protected $table = 'attendance_records';

    // تعطيل timestamps لو مش محتاجها
    // public $timestamps = false;
// في Attendance Model

public function user()
{
    return $this->belongsTo(User::class, 'student_id');
}

}
