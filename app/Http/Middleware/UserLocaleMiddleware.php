<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class UserLocaleMiddleware
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
        app()->setLocale(Session::get('locale', $request->getLocale()));
        return $next($request);
    }
}
