<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Attendance;
use App\Models\Note;

class AttendanceController extends Controller
{
    public function index()
    {
        $students = Student::all();
        return view('attendance', compact('students'));
    }

    public function store(Request $request)
{
    $statusMapping = [
        'حاضر' => 'present',
        'غائب' => 'absent',
        'متأخر' => 'late'
    ];

    foreach ($request->attendance as $student_id => $status) {
        // التحقق مما إذا كان الـ student_id موجودًا في جدول users
        if (!\App\Models\Student::where('id', $student_id)->exists()) {
            return redirect()->back()->with('error', "الطالب برقم ($student_id) غير موجود في قاعدة البيانات!");
        }
        Attendance::create([
            'student_id' => $student_id,
            'status' => $statusMapping[$status] ?? 'absent', // تحويل النص العربي إلى القيمة المناسبة
            'notes' => $request->notes[$student_id] ?? null,
            'date' => now()
        ]);
    }

    return redirect()->back()->with('success', 'تم تسجيل الحضور بنجاح!');
}



}
