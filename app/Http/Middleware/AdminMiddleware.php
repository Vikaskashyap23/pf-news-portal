<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(
        Request $request,
        Closure $next
    ): Response {

        $user = $request->user();

        /*
        |--------------------------------------------------------------------------
        | Authentication Check
        |--------------------------------------------------------------------------
        */

        if (!$user) {
            abort(401);
        }


        /*
        |--------------------------------------------------------------------------
        | Allowed Admin Panel Roles
        |--------------------------------------------------------------------------
        |
        | Only these two roles can enter the Admin Panel.
        |
        */

        if (!in_array($user->role, [
            'super_admin',
            'admin',
        ])) {
            abort(403, 'Unauthorized access.');
        }


        /*
        |--------------------------------------------------------------------------
        | Account Status
        |--------------------------------------------------------------------------
        */

        if (!$user->status) {
            abort(403, 'Your account is inactive.');
        }


        return $next($request);
    }
}