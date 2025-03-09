<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentModel extends Model
{
    use HasFactory;

    protected $table = 'parents'; // تأكد أن اسم الجدول صحيح في قاعدة البيانات

    protected $fillable = ['name', 'phone', 'email'];

    public $timestamps = false; // عطل timestamps إذا لم تكن الأعمدة `created_at` و `updated_at` موجودة

    protected $casts = [
        'name' => 'string',
        'phone' => 'string',
        'email' => 'string',
    ];

    // العلاقة بين ولي الأمر وأولاده
    public function children()
    {
        return $this->hasMany(User::class, 'parent_id'); // تأكد أن `parent_id` موجود في `users`
    }
}
