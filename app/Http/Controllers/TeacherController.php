<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\SchoolClass;
use App\Models\Attendance;
use App\Models\Note;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Teacher;

class TeacherController extends Controller
{
    public function __construct()
    {
        // تأكيد أن المستخدم مسجل دخول وأنه معلم
        // $this->middleware(['auth', 'teacher']);
    }

    // عرض لوحة تحكم المعلم
    public function dashboard()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'الرجاء تسجيل الدخول أولًا');
        }

        $teacherId = auth()->id();

        $presentCount = Attendance::where('status', 'present')->count();
        $absentCount = Attendance::where('status', 'absent')->count();

        $classes = SchoolClass::where('teacher_id', $teacherId)->get();
        $students = Student::whereHas('schoolClass', function ($query) use ($teacherId) {
            $query->where('teacher_id', $teacherId);
        })->get();

        $grades = SchoolClass::distinct()->pluck('grade');
        $notes = Note::where('teacher_id', $teacherId)->get();

        // تعليق السطر الخاص بعرض البيانات
        // dd($students, $classes, $grades, $notes);

        return view('dashboards.teacher', compact('presentCount', 'absentCount', 'students', 'classes', 'grades', 'notes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // تشفير الباسورد
            'role' => 'teacher',
        ]);

        Teacher::create([
            'user_id' => $user->id,
            'subject' => $request->subject,
        ]);

        return redirect()->route('teachers.index')->with('success', 'تم إضافة المعلم بنجاح');
    }

    // عرض الطلاب في الفصول الخاصة بالمعلم
    public function myStudents()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'الرجاء تسجيل الدخول أولًا');
        }

        $teacherId = auth()->id();
        $students = Student::whereHas('schoolClass', function ($query) use ($teacherId) {
            $query->where('teacher_id', $teacherId);
        })->with('schoolClass')->get();

        // تعليق السطر الخاص بعرض البيانات
        // return view('teacher.students', compact('students'));
    }

    // صفحة تسجيل الحضور
    public function attendanc()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'الرجاء تسجيل الدخول أولًا');
        }

        $teacherId = auth()->id();
        $students = Student::whereHas('schoolClass', function ($query) use ($teacherId) {
            $query->where('teacher_id', $teacherId);
        })->with('schoolClass')->get();

        // تعليق السطر الخاص بعرض البيانات
        // return view('teacher.attendance', compact('students'));
    }

    // تسجيل الحضور والغياب
    public function markAttendance(Request $request)
    {
        $request->validate([
            'attendance' => 'required|array',
            'attendance.*' => 'required|in:present,absent,late,excused',
        ]);

        foreach ($request->attendance as $studentId => $status) {
            $existingRecord = Attendance::where('student_id', $studentId)
                ->whereDate('date', now())
                ->first();

            if (!$existingRecord) {
                // تعليق السطر الخاص بحفظ البيانات
                // Attendance::create([
                //     'student_id' => $studentId,
                //     'teacher_id' => auth()->id(),
                //     'date' => now(),
                //     'status' => $status,
                // ]);
            }
        }

        return redirect()->route('teacher.attendance')->with('success', 'تم تسجيل الحضور بنجاح');
    }

    // صفحة إرسال ملاحظات
    public function sendNotes()
    {
        return view('teacher.notes');
    }

    // حفظ الملاحظات المرسلة
    public function storeNote(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'note' => 'required|string|max:1000',
        ]);

        // تعليق السطر الخاص بحفظ الملاحظات
        // Note::create([
        //     'teacher_id' => auth()->id(),
        //     'student_id' => $request->student_id,
        //     'note' => $request->note,
        // ]);

        return redirect()->route('teacher.notes')->with('success', 'تم إرسال الملاحظة بنجاح');
    }
}
