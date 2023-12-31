<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsPayerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->isPayer()) {
            return $next($request);
        }

        return response()->json([
            'message' => 'You must be a payer to access this resource.',
        ], 403);
    }
}
