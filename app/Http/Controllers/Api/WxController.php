<?php
/**
 * Created by PhpStorm.
 * User: luowen
 * Date: 2017/3/20
 * Time: 22:05
 */

namespace App\Http\Controllers\Api;


use App\Service\Api\MerchantService;
use App\Utils\DevEnvUtils;
use App\Utils\WxJsUtils;
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
            if(DevEnvUtils::isDevelopEnv()) {
                $userInfo = [
                    'id' => 1,
                    'openid' => 'abcdefIOk-wefladf-edgo1P',
                    'name' => 'super.luowen',
                    'isAvailable' => true,
                    'expireDays' => 10000,
                    'phone' => '13222221111',
                ];
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

    /**
     * 获取微信jstoken
     *
     * @param Request $request
     * @return $this|\Illuminate\Http\JsonResponse
     */
    public function jsToken(Request $request)
    {
        $this -> validate($request, [
            'url' => 'required',
        ], [
            'url.required' => '微信分享签名url不能为空',
        ]);
        $url = $request -> input("url");
        $jsTokenConfig = WxJsUtils::getWxJsConfig($url);
        return $this -> _sendJsonResponse('请求成功', $jsTokenConfig);
    }

}