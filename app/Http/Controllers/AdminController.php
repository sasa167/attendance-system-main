<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SchoolClass;
use App\Models\Attendance;
use App\Models\Student;
use App\Models\School;
use App\Models\Teacher;

class AdminController extends Controller
{
    public function __construct()
    {
        // $this->middleware(['auth', 'role:admin']);
    }

    public function dashboard()
    {
        // تأكد من جلب كائن المدرسة من قاعدة البيانات
        $school = School::first(); // إذا كانت هناك مدارس متعددة، يمكن تحديد المدرسة بناءً على المستخدم

        return view('dashboards.admin', [
            'school' => $school,
            'teachersCount' => Teacher::count(),
            'studentsCount' => Student::count(),
            'parentsCount' => User::where('role', 'parent')->count(),
        ]);
    }

    // إدارة المعلمين
    public function manageTeachers()
    {
        $teachers = Teacher::all(); // طالما عندك موديل مستقل للمعلمين
        return view('admin.teachers', compact('teachers'));
    }

    // إدارة الطلاب
    public function manageStudents()
    {
        $students = Student::all(); // طالما عندك موديل مستقل للطلاب
        return view('admin.students', compact('students'));
    }

    // إدارة أولياء الأمور
    public function manageParents()
    {
        $parents = User::where('role', 'parent')->get();
        return view('admin.parents', compact('parents'));
    }

    // إدارة الفصول الدراسية
    public function manageClasses()
    {
        $classes = SchoolClass::all();
        return view('admin.classes', compact('classes'));
    }

    // عرض تقارير الحضور والغياب
    public function attendanceReports()
    {
        $attendance = Attendance::all();
        return view('admin.attendance', compact('attendance'));
    }
}
