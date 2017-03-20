<?php

namespace App\Http\Middleware;

use Closure;

class ApiLoginMiddleware
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
        $session = $request -> getSession();
        if($user = $session -> get("_apiusers")) {
            $request -> setUserResolver(function () use ($user) {
                return $user;
            });
            return $next($request);
        }
        $request -> getUser();
        return false;
    }
}
