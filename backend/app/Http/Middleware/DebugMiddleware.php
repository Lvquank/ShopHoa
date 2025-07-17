<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DebugMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Log request details
        Log::info('Request Details:', [
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'headers' => $request->headers->all(),
            'cookies' => $request->cookies->all(),
            'token' => $request->header('X-XSRF-TOKEN'),
            'session_id' => $request->session()->getId(),
        ]);

        $response = $next($request);

        // Log response details
        Log::info('Response Details:', [
            'status' => $response->status(),
            'headers' => $response->headers->all(),
        ]);

        return $response;
    }
}
