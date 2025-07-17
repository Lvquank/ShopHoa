<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class HandleSession
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Đảm bảo cookie session được set đúng domain
        if (!$request->session()->has('initialized')) {
            $request->session()->put('initialized', true);
            $request->session()->save();
        }

        // Set cookie SameSite và domain phù hợp
        $response->headers->setCookie(
            cookie()->forever('session_active', true)
                ->withDomain('localhost')
                ->withSecure(false)
                ->withHttpOnly(false)
                ->withSameSite('Lax')
        );

        return $response;
    }
}
