<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProviderMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $user = auth('api')->user();

        if (!$user || $user->role !== 'provider') {
            return response()->json([
                'status' => false,
                'message' => 'unauthorized'
            ]);
        }
        return $next($request);
    }
}
