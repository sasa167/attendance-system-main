<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'school_id','grade'];

    public $timestamps = false; // إذا لم تكن هناك أعمدة `created_at` و `updated_at`

    protected $casts = [
        'name' => 'string',
        'grade' => 'string',
        'school_id' => 'integer',
    ];

    public function students()
    {
        return $this->hasMany(Student::class,);
    }


    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }
    public function school()
    {
        return $this->belongsTo(School::class, 'school_id'); // Assuming school_id is the foreign key
    }

}
