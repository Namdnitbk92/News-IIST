<?php

namespace App\Http\Middleware;

use Closure;

class isUsersManager
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!\Auth::user()->isUsersManager() && !\Auth::user()->isAdmin()) {
            return response()->view('errors.permission');
        }

        return $next($request);
    }
}
