<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\SchoolClassController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AttendanceController;


// الصفحة الرئيسية
Route::get('/', function () {
    return view('home');
})->name('home');

// تسجيل الدخول والتسجيل
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');

// ✅ عند زيارة `/login` يتم التوجيه للوحة التحكم مباشرةً إذا كان المستخدم مسجل دخول
// Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');

Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware(['auth'])->group(function () {
Route::get('/dashboards/superadmin', [SuperAdminController::class, 'dashboard'])->name('dashboards.superadmin');
Route::get('/dashboards/teacher', [TeacherController::class, 'dashboard'])->name('dashboards.teacher');
Route::get('/dashboards/parent', [ParentController::class, 'dashboard'])->name('dashboards.parent');
Route::get('/dashboards/admin', [AdminController::class, 'dashboard'])->name('dashboards.admin');
Route::post('/notes/store', [NoteController::class, 'store'])->name('notes.store');


Route::get('/dashboards/classes', [SchoolClassController::class, 'index'])->name('classes');
Route::post('/classes', [SchoolClassController::class, 'store'])->name('classes.store');
Route::put('/classes/{id}', [SchoolClassController::class, 'update'])->name('classes.update');
Route::delete('/classes/{id}', [SchoolClassController::class, 'destroy'])->name('classes.destroy');

Route::get('/dashboard/students', [StudentController::class, 'index'])->name('students.index');
Route::post('/students', [StudentController::class, 'store'])->name('students.store');
Route::put('/students/{id}', [StudentController::class, 'update'])->name('students.update');
Route::delete('/students/{id}', [StudentController::class, 'destroy'])->name('students.destroy');

Route::get('/dashboard/notes', [NoteController::class, 'index'])->name('note.index');
Route::get('/dashboard/add', [NoteController::class, 'store'])->name('note.add');


Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
Route::post('/attendance', [AttendanceController::class, 'store'])->name('attendance.store');

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');
});
