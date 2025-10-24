<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class JwtCookieMiddleware
{
    /**
     * Handle an incoming request.
     *
     * This middleware automatically adds JWT token from cookie to Authorization header
     * for seamless API authentication.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if JWT token exists in cookie
        $token = $request->cookie('jwt_token');

        // If token exists in cookie and no Authorization header is set
        if ($token && !$request->hasHeader('Authorization')) {
            // Add the token to the request headers
            $request->headers->set('Authorization', 'Bearer ' . $token);
        }

        return $next($request);
    }

    /**
     * Helper method to set JWT token cookie
     *
     * @param string $token
     * @param int $minutes
     * @return \Symfony\Component\HttpFoundation\Cookie
     */
    public static function setJwtCookie($token, $minutes = 60)
    {
        return \Illuminate\Support\Facades\Cookie::make('jwt_token', $token, $minutes, '/', null, false, true, false, 'None');
    }

    /**
     * Helper method to clear JWT token cookie
     *
     * @return \Symfony\Component\HttpFoundation\Cookie
     */
    public static function clearJwtCookie()
    {
        return \Illuminate\Support\Facades\Cookie::forget('jwt_token', '/');
    }
}