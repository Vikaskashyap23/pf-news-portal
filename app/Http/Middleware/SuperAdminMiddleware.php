<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminMiddleware
{
    public function handle(
        Request $request,
        Closure $next
    ): Response {

        $user = $request->user();

        if (!$user) {
            abort(401);
        }

        if (!$user->status) {
            abort(403, 'Your account is inactive.');
        }

        if ($user->role !== 'super_admin') {
            abort(403, 'Only Super Admin can access this section.');
        }

        return $next($request);
    }
}