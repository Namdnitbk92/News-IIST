<?php

namespace App\Http\Middleware;

use Closure;

class isContentManager
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
        if (!\Auth::user()->isCreater() && !\Auth::user()->isApprover() && !\Auth::user()->isAdmin()) {
            return response()->view('errors.permission');
        }

        return $next($request);
    }
}
