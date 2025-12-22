<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class AdminRateLimiter
{
    /**
     * Handle an incoming request.
     * Prevents brute force attempts on admin panel
     */
    public function handle(Request $request, Closure $next): Response
    {
        $key = 'admin-access:' . $request->ip();

        // Allow 10 attempts per minute
        if (RateLimiter::tooManyAttempts($key, 10)) {
            $seconds = RateLimiter::availableIn($key);

            return response()->view('errors.429', [
                'message' => 'Too many access attempts. Please try again in ' . $seconds . ' seconds.',
                'retry_after' => $seconds,
            ], 429);
        }

        RateLimiter::hit($key, 60);

        return $next($request);
    }
}
