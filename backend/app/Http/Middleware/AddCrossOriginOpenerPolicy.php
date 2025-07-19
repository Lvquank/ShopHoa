<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AddCrossOriginOpenerPolicy
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Lấy response từ ứng dụng
        $response = $next($request);

        // Thêm header cần thiết vào response
        $response->headers->set('Cross-Origin-Opener-Policy', 'same-origin-allow-popups');

        return $response;
    }
}
