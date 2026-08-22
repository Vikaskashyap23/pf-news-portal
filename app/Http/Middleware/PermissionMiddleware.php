<?php

namespace App\Http\Middleware;

use App\Services\PermissionService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PermissionMiddleware
{
    public function handle(
        Request $request,
        Closure $next,
        string $permission
    ): Response {
        $user = $request->user();

        if (!$user) {
            abort(401);
        }

        $permissionService = app(PermissionService::class);

        if (!$permissionService->hasPermission($user, $permission)) {
            abort(403, 'You do not have permission to access this page.');
        }

        return $next($request);
    }
}