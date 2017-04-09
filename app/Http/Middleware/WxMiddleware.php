<?php

namespace App\Http\Middleware;

use App\Exceptions\NotInWxException;
use App\Utils\DevEnvUtils;
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
        $isWx = $session -> get("_userinfo");
        if($isWx || DevEnvUtils::isDevelopEnv()) {
            return $next($request);
        }

        /* only allow one time for request */
        $userAgent = $request -> header('User-Agent');
        $wxAgent = $session -> get("_wxagent", false);
        if(strpos($userAgent, 'MicroMessenger') !== false && !$wxAgent) {
            $session -> set("_wxagent", 1);
            $session -> save();
            return $next($request);
        }

        throw new NotInWxException("非法请求: [确认在微信中访问, 或重新登入]");
    }
}
