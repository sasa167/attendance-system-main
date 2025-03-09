<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Attendance;
use App\Models\Note;
use Illuminate\Support\Facades\Auth;

class ParentController extends Controller
{
    public function dashboard()
    {
        // جلب بيانات الأب الحالي
        $parent = Auth::user();

        // التأكد أن المستخدم مسجل دخول
        if (!$parent) {
            return redirect()->route('login')->with('error', 'الرجاء تسجيل الدخول');
        }

        // جلب جميع الأبناء المرتبطين بهذا الأب
        $students = Student::where('parent_id', $parent->id)->get();

        // التحقق إذا كان الأب لديه أبناء
        if ($students->isEmpty()) {
            return view('dashboards.parent')->with('message', 'لا يوجد أبناء مسجلين.');
        }

        // تجهيز بيانات الحضور والملاحظات
        $attendanceData = [];
        $notesData = [];

        foreach ($students as $student) {
            $attendanceData[$student->id] = Attendance::where('student_id', $student->id)
                ->orderBy('date', 'desc')
                ->get();

            $notesData[$student->id] = Note::where('student_id', $student->id)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        // إرسال البيانات إلى الـ View
        return view('dashboards.parent', compact('students', 'attendanceData', 'notesData'));
    }
}
