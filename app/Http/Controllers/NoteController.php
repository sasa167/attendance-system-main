<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Student;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    public function index()
    {
        $students = Student::all();
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

            // $notesData[$student->id] = Note::where('student_id', $student->id)
            //     ->orderBy('created_at', 'desc')
            //     ->get();
        }
        return view('notes', compact('students', 'attendanceData', 'notesData'));    }

    public function store(Request $request)
    {
        $request->validate([
            'teacher_id' => 'required|',
            'student_id' => 'required',
            'note' => 'required|string',
        ]);

        Note::create([
            'teacher_id' => (int) $request->teacher_id,
            'student_id' => (int) $request->student_id,
            'content' => $request->note,
            // 'date' => now(),
        ]);

        return redirect()->back()->with('message', 'تم إضافة الملاحظة بنجاح');
    }

    public function show($id)
    {
        $note = Note::with('user')->find($id);
        if (!$note) {
            return response()->json(['message' => 'Note not found'], 404);
        }

        return response()->json($note, 200);
    }

    public function update(Request $request, $id)
    {
        $note = Note::find($id);
        if (!$note) {
            return response()->json(['message' => 'Note not found'], 404);
        }

        // التحقق من أن المستخدم يملك الملاحظة
        if ($note->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // تحقق أن الطلب يحتوي على بيانات فعلًا
        if (!$request->has('content')) {
            return response()->json(['message' => 'No content provided'], 400);
        }

        $validated = $request->validate([
            'content' => 'string',
        ]);

        $note->update($validated);
        return response()->json($note, 200);
    }

    public function destroy($id)
    {
        $note = Note::find($id);
        if (!$note) {
            return response()->json(['message' => 'Note not found'], 404);
        }

        // التحقق من أن المستخدم يملك الملاحظة
        if ($note->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $note->delete();
        return response()->json(['message' => 'Note deleted successfully'], 200);
    }
}
