<?php

namespace App\Http\Middleware;

use App\Exceptions\UserExpiredException;
use App\Utils\DevEnvUtils;
use Closure;

class UserDuration
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
        $userInfo = $session -> get("_userinfo");

        if(DevEnvUtils::isDevelopEnv()) {
            return $next($request);
        }

        if(is_array($userInfo) && !empty($userInfo)
            && isset($userInfo['isAvailable']) && $userInfo['isAvailable']) {
            return $next($request);
        }
        throw new UserExpiredException("非法请求: [用户到期了]");
    }
}
