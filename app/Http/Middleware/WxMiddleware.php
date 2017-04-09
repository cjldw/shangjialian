<?php

namespace App\Http\Middleware;

use App\Exceptions\NotInWxException;
use App\Utils\DevEnvUtils;
use Closure;

class WxMiddleware
{
    const MAX_ALLOW_REQUEST = 20;
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
        $wxAgent = intval($session -> get("_wxagent", 0));
        if(strpos($userAgent, 'MicroMessenger') !== false) {
            if($wxAgent <= self::MAX_ALLOW_REQUEST) {
                $session -> put("_wxagent", ++$wxAgent);
                $session -> save();
                return $next($request);
            }
        }

        throw new NotInWxException("非法请求: [确认在微信中访问, 或重新登入]");
    }
}
