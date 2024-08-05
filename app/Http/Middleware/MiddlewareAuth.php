<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MiddlewareAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->bearerToken()) {
            return response()->json([
                'message' => 'Login failed'
            ]);
        }
        
        $user = User::where('token', $request->bearerToken())->first();
        
        if (!$user) {
            return response()->json([
                'message' => 'Login failed'
            ]);
        }
        return $next($request);
    }
}
