<?php

namespace App\Http\Middleware;

use App\Models\Domain;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ResolveWebsiteDomain
{
    public function handle(Request $request, Closure $next): Response
    {
        $host = strtolower($request->getHost());

        $domain = Domain::with('website')
            ->where('domain', $host)
            ->whereIn('status', ['verified', 'active'])
            ->first();

        if ($domain && $domain->website) {
            app()->instance('currentWebsite', $domain->website);
        }

        return $next($request);
    }
}