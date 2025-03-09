<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\School;
use App\Models\Attendance;
use App\Models\Student;
use App\Models\ParentModel;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user(); // جلب المستخدم الحالي

        // بيانات خاصة بالـ Super Admin
        if ($user->role === 'superadmin') {
            $schoolsCount = School::count();
            $teachersCount = User::where('role', 'Teacher')->count(); // عدد المعلمين
            $studentsCount = Student::count();
            $parentsCount = ParentModel::count();
            $parents = ParentModel::all(); // جلب كل الآباء

            return view('dashboards.superadmin', compact('schoolsCount', 'teachersCount', 'studentsCount', 'parentsCount', 'parents'));
        }

        // بيانات خاصة بالأدمن (مدير المدرسة)
        if ($user->role === 'admin') {
            $school = $user->school; // المدرسة التي يتبعها
            $teachersCount = User::where('role', 'Teacher')->where('school_id', $school->id)->count();
            $studentsCount = $school->students->count();
            $parentsCount = $school->parents->count();
            $parents = $school->parents; // جلب الآباء المرتبطين بالمدرسة فقط

            return view('dashboards.admin', compact('school', 'teachersCount', 'studentsCount', 'parentsCount', 'parents'));
        }

        // بيانات خاصة بالمعلم
        if ($user->role === 'teacher') {
            $students = Student::where('school_id', $user->school_id)->get();
            $today = now()->toDateString();
            $presentCount = Attendance::where('date', $today)->where('status', 'present')->count();
            $absentCount = Attendance::where('date', $today)->where('status', 'absent')->count();

            return view('dashboards.teacher', compact('presentCount', 'absentCount', 'students', 'classes', 'grades', 'notes'));
        }

        // بيانات خاصة بالآباء لمتابعة حالة أبنائهم
        if ($user->role === 'parent') {
            $children = $user->children; // الأبناء المرتبطين بهذا الحساب
            return view('dashboards.parent', compact('children'));
        }

        return abort(403); // منع الوصول لو الدور غير معروف
    }
}
