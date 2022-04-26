<?php

namespace App\Http\Middleware;

use Closure;

class RoleMiddleware
{

    public function handle($request, Closure $next, ...$roles)
    {
        if (in_array(auth()->user()->role, $roles)) return $next($request);
        return response()->json(['status' => 403, 'message' => 'Доступ запрещен.'], 403);
    }
}
