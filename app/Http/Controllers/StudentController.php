<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\School;
use App\Models\SchoolClass;
use App\Models\User;
use App\Models\ParentModel;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $schools = School::all();
        $schoolClasses = SchoolClass::all();
        $parents = User::where('role','parent')->get();
        $students = Student::with(['school', 'schoolClass', 'parent'])->get();
        return view('students', compact('students', 'schools', 'parents', 'schoolClasses'));
    }

    public function store(Request $request)
{
    // $validated = $request->validate([
    //     'name' => 'required|string|max:255',
    //     'school_id' => 'required|exists:schools,id',
    //     'parent_id' => 'required|exists:parents,id',
    //     'class_id' => 'required|exists:school_classes,id',
    // ]);
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'school_id' => 'required',
        'parent_id' => 'required',
        'class_id' => 'required',
    ]);

    // إنشاء الطالب
    $student = Student::create([
        'name' => $validated['name'],
        'school_id' => $validated['school_id'],
        'parent_id' => $validated['parent_id'],
        'class_id' => $validated['class_id'],
    ]);

    // إنشاء المستخدم بنفس ID الطالب
    // User::create([
    //     'id' => $student->id, // نفس ID الطالب
    //     'name' => $student->name,
    //     'email' => 'student' . $student->id . '@school.com', // أو أي منطق لتوليد البريد الإلكتروني
    //     'password' => bcrypt('123456'), // تعيين كلمة مرور افتراضية
    //     'role' => 'student', // تحديد الدور إذا كان هناك نظام صلاحيات
    // ]);

    return redirect()->back()->with('success', 'تمت إضافة الطالب وإنشاء المستخدم بنجاح');
}


public function update(Request $request, $id)
{
    $student = Student::findOrFail($id);

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'school_id' => 'required',
        'parent_id' => 'required',
        'class_id' => 'required',
    ]);

    $student->update([
        'name' => $validated['name'],
        'school_id' => $validated['school_id'],
        'parent_id' => $validated['parent_id'],
        'class_id' => $validated['class_id'],
    ]);

    // تحديث بيانات المستخدم المرتبط بالطالب
    // User::where('id', $student->id)->update([
    //     'name' => $student->name,
    // ]);

    return redirect()->back()->with('success', 'تم تحديث بيانات الطالب والمستخدم بنجاح');
}


    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();

        return redirect()->back()->with('success', 'تم حذف الطالب بنجاح');
    }
}
