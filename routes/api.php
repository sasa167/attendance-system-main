<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\SchoolClassController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\ParentController;
use App\Models\SchoolClass;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TeacherController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('register', [AuthController::class, 'register']);
Route::post('login',    [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('api')->group(function () {
    Route::get('/attendances', [AttendanceController::class, 'index']);

    //school
    Route::get('/schools', [SchoolController::class, 'index']);
    Route::post('/new_school',         [SchoolController::class, 'store']);
    Route::get('/show_school/{id}',    [SchoolController::class, 'show']);
    Route::post('/update_school/{id}', [SchoolController::class, 'update']);
    Route::post('/delete_school/{id}', [SchoolController::class, 'destroy']);


//Attendance
Route::get('/attendances', [AttendanceController::class, 'index']);
    Route::post('/newAttendance',          [AttendanceController::class, 'store']);
    Route::get('/showAttendance/{id}',     [AttendanceController::class, 'show']);
    Route::post('/updateAttendance/{id}',  [AttendanceController::class, 'update']);
    Route::post('/deleteAttendance/{id}',  [AttendanceController::class, 'destroy']);


//Note
    Route::get('/Notes',            [NoteController::class, 'index']);
    Route::post('/newNote',         [NoteController::class, 'store']);
    Route::get('/showNote/{id}',    [NoteController::class, 'show']);
    Route::post('/updateNote/{id}', [NoteController::class, 'update']);
    Route::post('/deleteNote/{id}', [NoteController::class, 'destroy']);


//Parent
Route::get('/Parents ', [ParentController::class, 'index']); // المسافة بعد Parents
    Route::post('/newParent',         [ParentController::class, 'store']);
    Route::get('/showParent/{id}',    [ParentController::class, 'show']);
    Route::post('/updateParent/{id}', [ParentController::class, 'update']);
    Route::post('/deleteParent/{id}', [ParentController::class, 'destroy']);


// SchoolClass
    Route::get('/schoolClasses',           [SchoolClassController::class, 'index']);
    Route::post('/newSchoolClass',         [SchoolClassController::class, 'store']);
    Route::get('/showSchoolClass/{id}',    [SchoolClassController::class, 'show']);
    Route::post('/updateSchoolClass/{id}', [SchoolClassController::class, 'update']);
    Route::post('/deleteSchoolClass/{id}', [SchoolClassController::class, 'destroy']);


// User
Route::get('/users ', [UserController::class, 'index']); // المسافة بعد users
    Route::post('/newUser',         [UserController::class, 'store']);
    Route::get('/showUser/{id}',    [UserController::class, 'show']);
    Route::post('/updateUser/{id}', [UserController::class, 'update']);
    Route::post('/deleteUser/{id}', [UserController::class, 'destroy']);
});



Route::middleware('auth:api')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('profile', [AuthController::class, 'profile']);
});


Route::middleware(['auth', 'SuperAdmin'])->prefix('superadmin')->group(function () {
    Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])->name('superadmin.dashboard');
    Route::get('/users', [SuperAdminController::class, 'manageUsers'])->name('superadmin.users');
    Route::get('/users/edit/{id}', [SuperAdminController::class, 'editUser'])->name('superadmin.users.edit');
    Route::post('/users/update/{id}', [SuperAdminController::class, 'updateUser'])->name('superadmin.users.update');
    Route::delete('/users/delete/{id}', [SuperAdminController::class, 'deleteUser'])->name('superadmin.users.delete');
});


Route::middleware(['auth', 'Admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/teachers', [AdminController::class, 'manageTeachers'])->name('admin.teachers');
    Route::get('/students', [AdminController::class, 'manageStudents'])->name('admin.students');
    Route::get('/parents', [AdminController::class, 'manageParents'])->name('admin.parents');
    Route::get('/classes', [AdminController::class, 'manageClasses'])->name('admin.classes');
    Route::get('/subjects', [AdminController::class, 'manageSubjects'])->name('admin.subjects');
    Route::get('/attendance', [AdminController::class, 'attendanceReports'])->name('admin.attendance');
});



Route::middleware(['auth', 'Teacher'])->prefix('teacher')->group(function () {
    Route::get('/dashboard', [TeacherController::class, 'dashboard'])->name('teacher.dashboard');
    Route::get('/students', [TeacherController::class, 'myStudents'])->name('teacher.students');
    Route::get('/attendance', [TeacherController::class, 'attendance'])->name('teacher.attendance');
    Route::post('/attendance/mark', [TeacherController::class, 'markAttendance'])->name('teacher.attendance.mark');
    Route::get('/notes', [TeacherController::class, 'sendNotes'])->name('teacher.notes');
    Route::post('/notes/store', [TeacherController::class, 'storeNote'])->name('teacher.notes.store');
});


Route::middleware(['auth', 'role:parent'])->group(function () {
    Route::get('/parent/attendance', [ParentController::class, 'viewAttendance'])->name('parent.attendance');
    Route::get('/parent/notifications', [ParentController::class, 'notifications'])->name('parent.notifications');
    Route::get('/parent/message-teachers', [ParentController::class, 'messageTeachers'])->name('parent.messageTeachers');
});
