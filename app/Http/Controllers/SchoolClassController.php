<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\School;
use Illuminate\Http\Request;

class SchoolClassController extends Controller
{
    public function index()
    {
        // جلب جميع الفصول مع المدرسة التابعة لها
        $classes = SchoolClass::all();
        $schools = School::all();
        return view('classes', compact('classes', 'schools'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'grade' => 'required|string|max:255',
            'school_id' => 'required',
        ]);

        SchoolClass::create($validated);
        return redirect()->back()->with('success', 'تمت إضافة الفصل بنجاح!');
    }

    public function update(Request $request, $id)
    {
        $class = SchoolClass::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'grade' => 'sometimes|string|max:255',
            'school_id' => 'sometimes',
        ]);

        $class->update($validated);
        return redirect()->back()->with('success', 'تم تعديل الفصل بنجاح!');
    }

    public function destroy($id)
    {
        $class = SchoolClass::findOrFail($id);
        $class->delete();
        return redirect()->back()->with('success', 'تم حذف الفصل بنجاح!');
    }

}
