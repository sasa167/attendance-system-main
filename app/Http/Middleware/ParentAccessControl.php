<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ParentAccessControl
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        // تأكد أن المستخدم مسجل دخول ولديه دور "parent"
        if ($user && $user->role === 'parent') {
            // تحديد الراوتات التي لا يجب أن يصل إليها
            $restrictedRoutes = ['attendance.store', 'attendance.update', 'attendance.destroy'];

            if (in_array($request->route()->getName(), $restrictedRoutes)) {
                abort(403, 'Unauthorized action.');
            }
        }

        return $next($request);
    }
}
