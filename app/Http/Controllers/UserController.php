<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with(['class.school', 'parent'])->get();
        return response()->json($users);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'class_id' => 'required|exists:school_classes,id',
            'parent_id' => 'nullable|exists:parents,id',
        ]);

        $validated['password'] = Hash::make($validated['password']); // تشفير كلمة المرور

        $user = User::create($validated);

        return response()->json($user, 201);
    }

    public function show($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json($user, 200);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $validated = $request->validate([
            'name' => 'string|max:255',
            'email' => 'email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']); // تشفير كلمة المرور عند التحديث
        } else {
            unset($validated['password']); // إزالة الحقل إذا لم يكن موجودًا
        }

        $user->update($validated);
        return response()->json($user, 200);
    }

    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // حذف الطالب إذا كان موجودًا
        Student::where('id', $id)->delete();

        // حذف المستخدم
        $user->delete();

        return response()->json(['message' => 'User and student (if exists) deleted successfully'], 200);
    }

}
