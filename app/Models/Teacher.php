<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;
    protected $table = 'teachers'; // تأكد أن اسم الجدول صحيح في قاعدة البيانات


    public function students()
{
    return $this->hasManyThrough(Student::class, SchoolClass::class, 'teacher_id', 'class_id');
}

public function notes()
{
    return $this->hasMany(Note::class, 'teacher_id');

}

public function classes()
{
    return $this->hasMany(SchoolClass::class, 'teacher_id');
}

}
