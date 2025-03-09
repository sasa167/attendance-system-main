<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, ...$guards)
    {
        if (Auth::check()) {
            $user = Auth::user();

            if ($user->role === 'superadmin') {
                return redirect('/dashboards/superadmin');
            } elseif ($user->role === 'admin') {
                return redirect('/dashboards/admin');
            } elseif ($user->role === 'teacher') {
                return redirect('/dashboards/teacher');
            } elseif ($user->role === 'parent') {
                return redirect('/dashboards/parent');
            } else {
                return redirect(route('home')); // 🔹 استبدل `/login` بـ `route('home')`
            }
        }

        return $next($request);
    }


}
