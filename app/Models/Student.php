<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // ✅ لازم تستوردها هنا


class Student extends Model
{
    use HasFactory;
    protected $table = 'students'; // تأكد أن اسم الجدول صحيح في قاعدة البيانات


    protected $fillable = ['name', 'class_id', 'class' , 'school_id', 'parent_id', 'school_class_id'];

    public $timestamps = false; // إذا لم تكن هناك أعمدة `created_at` و `updated_at`

    protected $casts = [
        'name' => 'string',
        'class_id' => 'integer',
    ];

    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }
    public function school()
    {
        return $this->belongsTo(School::class, 'school_id');
    }

    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }
}
