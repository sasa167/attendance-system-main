<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        // إنشاء المستخدم
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'parent', // تعيين الدور تلقائيًا
        ]);

        // تخزين رسالة النجاح في الـ session
        session()->flash('success', 'تم تسجيل حساب جديد بنجاح، يمكنك الآن تسجيل الدخول.');

        // إعادة التوجيه إلى الصفحة الرئيسية أو صفحة تسجيل الدخول
        return redirect('/'); // أو '/login' حسب ما تفضله
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();

            // تحقق من وجود دور للمستخدم
            if (!$user->role) {
                Auth::logout();
                return redirect()->back()->with('error', 'لم يتم تعيين دور لهذا الحساب');
            }
            // توجيه المستخدم إلى الـ Dashboard المناسب بناءً على دوره
            return redirect($this->redirectToDashboard($user->role));
        }
        return redirect()->route('home')->with('error', 'البريد الإلكتروني أو كلمة المرور غير صحيحة');
    }

    // دالة لتحويل المستخدم للـ Dashboard الخاصة به
    public function redirectToDashboard($role)
    {
        switch ($role) {
            case 'superadmin':
                return route('dashboards.superadmin');
            case 'admin':
                return route('dashboards.admin');
            case 'teacher':
                return route('dashboards.teacher');
            case 'parent':
                return route('dashboards.parent');
            default:
                return route('/'); // إذا لم يكن هناك دور محدد
        }
    }

    public function profile()
    {
        return response()->json(Auth::user());
    }

    public function refresh()
    {
        try {
            if (!$token = JWTAuth::getToken()) {
                return response()->json(['error' => 'Token not provided'], 401);
            }

            $newToken = JWTAuth::refresh($token);
            return response()->json(['token' => $newToken]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Token refresh failed'], 401);
        }
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }
    public function showLoginForm()
    {
        if (auth()->check()) {
            return redirect()->route($this->getDashboardRoute()); // توجيه المستخدم إلى لوحة التحكم الخاصة به
        }
        return view('auth.login'); // عرض صفحة تسجيل الدخول إذا لم يكن مسجل دخول
    }

    // دالة لتحديد لوحة التحكم المناسبة حسب دور المستخدم
    private function getDashboardRoute()
    {
        switch (auth()->user()->role) {
            case 'superadmin':
                return 'dashboards.superadmin';
            case 'admin':
                return 'dashboards.admin';
            case 'teacher':
                return 'dashboards.teacher';
            case 'parent':
                return 'dashboards.parent';
            default:
                return '/'; // توجيه افتراضي في حالة عدم وجود دور
        }
    }

}
