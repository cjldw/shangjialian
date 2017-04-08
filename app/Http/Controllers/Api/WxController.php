<?php
/**
 * Created by PhpStorm.
 * User: luowen
 * Date: 2017/3/20
 * Time: 22:05
 */

namespace App\Http\Controllers\Api;


use App\Service\Api\MerchantService;
use App\Utils\WxUtils;
use Illuminate\Http\Request;

class WxController extends BaseController
{
    public function authorization(Request $request)
    {
        $redirectUrl = WxUtils::getRedirectUri();
        return $this -> _sendJsonResponse("请求成功", ['redirectUrl' => $redirectUrl]);
    }

    public function userinfo(Request $request)
    {
        $code = $request -> input("code");
        if($code) {
            $userInfo = WxUtils::getWxOpenId($code);
            $env = config("app.env");
            if($env != 'production') {
                $userInfo['openid'] = 'abcdefIOk-wefladf-edgo1P';
            }
            /* just for test */
            if(isset($userInfo['openid'])) {
                $merchantRepo = new MerchantService();
                $merchantInfo = $merchantRepo -> getUserInfo($userInfo['openid']);
                /* mark as wx */
                $session = $request -> getSession();
                $session -> put("_userinfo", $merchantInfo);
                $session -> save();
                return $this -> _sendJsonResponse("请求成功", $merchantInfo);
            }
        }
        return $this -> _sendJsonResponse("请求失败", $request -> all(), false);
    }

}