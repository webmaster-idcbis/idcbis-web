<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureApiPermission
{
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        $user = $request->user();

        if (! $user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $permissions = array_values(array_filter(explode('|', $permission)));

        if (! $user->canAny($permissions)) {
            return response()->json([
                'message' => 'No tienes permiso para esta acción.',
            ], 403);
        }

        return $next($request);
    }
}
