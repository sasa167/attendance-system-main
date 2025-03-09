<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\School;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\ParentModel;

class SuperAdminController extends Controller
{
    public function __construct()
    {
        // $this->middleware(['auth', 'role:superadmin']);
    }

    public function dashboard()
    {
        session()->flash('welcomeMessage', 'مرحبًا بك في لوحة تحكم السوبر أدمن!');
        return view('dashboards.superadmin', [
            'schoolsCount' => School::count(),
            'teachersCount' => Teacher::count(),
            'studentsCount' => Student::count(),
            'parentsCount' => ParentModel::count(),
        ]);
    }

    // إدارة المستخدمين
    public function manageUsers()
    {
        $users = User::all();
        return view('superadmin.users', compact('users'));
    }

    // تعديل مستخدم معين
    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('superadmin.edit-user', compact('user'));
    }

    // تحديث بيانات المستخدم
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // التحقق من صحة البيانات
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6|confirmed',
            'role' => 'required|in:admin,superadmin,teacher,parent',
        ]);

        // تحديث البيانات مع تجنب تعديل كلمة المرور إذا لم يتم إدخالها
        if ($request->filled('password')) {
            $validated['password'] = bcrypt($request->password);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);
        return redirect()->route('superadmin.users')->with('success', 'تم تحديث المستخدم بنجاح');
    }

    // حذف مستخدم
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);

        // منع حذف السوبر أدمن الأساسي
        if ($user->role === 'superadmin') {
            return redirect()->route('superadmin.users')->with('error', 'لا يمكن حذف السوبر أدمن الرئيسي!');
        }

        $user->delete();
        return redirect()->route('superadmin.users')->with('success', 'تم حذف المستخدم بنجاح');
    }
}
