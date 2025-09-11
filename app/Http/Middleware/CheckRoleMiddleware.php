<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // إذا المستخدم ممسجل دخول → رجّعه لتسجيل الدخول
        if (!$request->user()) {
            return redirect('/login');
        }

        $userRole = $request->user()->role;

        // ✅ إذا كان SuperAdmin → يدخل على كلشي
        if ($userRole === 'superadmin') {
            return $next($request);
        }

        // ✅ إذا كان دوره ضمن الرولز المطلوبة للراوت → يدخل
        if (in_array($userRole, $roles)) {
            return $next($request);
        }

        // ❌ غير مسموح
        return abort(403, 'Unauthorized');
    }
}