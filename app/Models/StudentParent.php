<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentParent extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'parent_id'];

    public $timestamps = false; // إذا لم تكن هناك `created_at` و `updated_at`

    protected $casts = [
        'student_id' => 'integer',
        'parent_id' => 'integer',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function parent()
    {
        return $this->belongsTo(ParentModel::class, 'parent_id');
    }
}
