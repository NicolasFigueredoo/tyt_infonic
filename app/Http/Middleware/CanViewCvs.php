<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CanViewCvs
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->guard('web')->user();

        if (!$user || !$user->can_view_cvs) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        return $next($request);
    }
}