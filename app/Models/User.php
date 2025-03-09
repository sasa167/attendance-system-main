<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject; // ✅ استدعاء JWTSubject
use Illuminate\Support\Facades\Hash;
use App\Models\Role;


class User extends Authenticatable implements JWTSubject // ✅ تطبيق JWTSubject
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role'];

    protected $hidden = ['password'];

    protected $casts = [
        'class_id' => 'integer',
        'parent_id' => 'integer',
    ];

    // ✅ تنفيذ دوال JWT
    public function getJWTIdentifier()
    {
        return $this->getKey(); // عادةً الـ id الخاص بالمستخدم
    }

    public function getJWTCustomClaims()
    {
        return []; // يمكنك إضافة بيانات إضافية هنا لو حبيت
    }

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function parent()
    {
        return $this->belongsTo(ParentModel::class);
    }

    // public function attendances()
    // {
    //     return $this->hasMany(Attendance::class);
    // }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    public static function canEnter($allowedRoles)
    {
        $user = auth()->user();

        if (!$user) {
            abort(403, 'عذرًا، أنت غير مسجل الدخول.');
        }

        if (in_array($user->role, $allowedRoles)) {
            return true;
        }

        abort(403, 'عذرًا، ليس لديك الصلاحية.');
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function student()
{
    return $this->hasOne(Student::class, 'parent_id'); // تأكد أن 'parent_id' هو المفتاح الصحيح
}

// في User Model
public function attendances()
{
    return $this->hasMany(Attendance::class, 'student_id');
}



}
