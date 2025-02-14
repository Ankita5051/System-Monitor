<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class InvalidRouteHandler
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($response->status() == 404) {
            return response()->json([
                'message' => 'Invalid URL. Redirecting to home...',
                'status' => 404
            ],200)->header('Location', url('/'));
        }

        return $response;
    }
}
