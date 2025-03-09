<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class SchoolController extends Controller
{
    public function index()
    {
        // التحقق من صلاحية المستخدم باستخدام Gate أو Policy
        $this->authorize('viewAny', School::class);

        $schools = School::all();
        return response()->json($schools);
    }

    public function store(Request $request)
    {
        $this->authorize('create', School::class);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
        ]);

        $school = School::create($validated);
        return response()->json($school, 201);
    }

    public function show($id)
    {
        $school = School::findOrFail($id);
        $this->authorize('view', $school);
        return response()->json($school);
    }

    public function update(Request $request, $id)
    {
        $school = School::findOrFail($id);
        $this->authorize('update', $school);

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'address' => 'sometimes|nullable|string',
            'phone' => 'sometimes|nullable|string|max:20',
        ]);

        $school->update($validated);
        return response()->json($school);
    }

    public function destroy($id)
    {
        $school = School::findOrFail($id);
        $this->authorize('delete', $school);

        $school->delete();
        return response()->json(['message' => 'School deleted successfully'], 200);
    }
}
