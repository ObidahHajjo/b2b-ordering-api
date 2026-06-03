<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Allow only admin users.
     *
     * @param  Request  $request  Incoming request.
     * @param  \Closure(Request): Response  $next
     * @return Response Next response.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()?->hasRole('admin')) {
            abort(Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
