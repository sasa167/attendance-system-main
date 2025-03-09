<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuperAdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->role !== 'superadmin') {
            abort(403, 'Unauthorized');
        }
        

        return redirect('/')->with('error', 'ليس لديك الصلاحية للوصول إلى هذه الصفحة');
    }
}
