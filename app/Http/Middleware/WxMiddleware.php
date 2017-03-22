<?php

namespace App\Http\Middleware;

use App\Exceptions\NotInWxException;
use Closure;

class WxMiddleware
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
        $isWx = $session -> get("_openid");
        if($isWx) {
            return $next($request);
        }
        throw new NotInWxException("非法请求: [确认在微信中访问]");
    }
}
