<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ModeratorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()->role !== 'moderator') {
            return response()->json([
                'message' => __('error.unauth'),
                'errors' => ['route' => [__('error.unauth')]]
            ], 403);
        }


        return $next($request);
    }

}
