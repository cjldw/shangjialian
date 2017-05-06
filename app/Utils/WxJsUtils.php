<?php
/**
 * Created by PhpStorm.
 * User: luowen
 * Date: 2017/4/20
 * Time: 22:58
 */

namespace App\Utils;

use App\Exceptions\WxException;
use Cache;
use Carbon\Carbon;

class WxJsUtils
{

    const WX_ACCESS_TOKEN_CACHE_KEY = '_wx_access_token_';

    const WX_JS_TICKET_TOKEN_CACHE_KEY = '_wx_js_ticket_token_';

    public static function getWxJsConfig($url = '')
    {
        $accessTokenUrl = WxUtils::getAccessTokenUrl();
        $accessToken = Cache::get(self::WX_ACCESS_TOKEN_CACHE_KEY, false);
        if(!$accessToken) {
            $wxResp = json_decode(HttpUtil::get($accessTokenUrl), true);
            if(!(is_array($wxResp) && isset($wxResp['access_token']))) {
                throw  new WxException('获取微信token异常');
            }
            $accessToken = $wxResp['access_token'];
            $expireIn = $wxResp['expires_in'];
            Cache::put(self::WX_ACCESS_TOKEN_CACHE_KEY, $accessToken, Carbon::now() -> addSecond($expireIn - 10));
        }

        $jsTicketToken = Cache::get(self::WX_JS_TICKET_TOKEN_CACHE_KEY, false);
        if(!$jsTicketToken) {
            $jsTicketTokenUrl = WxUtils::getJsTicketUrl($accessToken);
            $wxResp = json_decode(HttpUtil::get($jsTicketTokenUrl), true);

            if(!(is_array($wxResp) && isset($wxResp['ticket']))) {
                throw new WxException("获取微信jsTicket异常");
            }

            $jsTicketToken = $wxResp['ticket'];
            $expireIn = $wxResp['expires_in'];
            Cache::put(self::WX_JS_TICKET_TOKEN_CACHE_KEY, $jsTicketToken, Carbon::now() -> addSecond($expireIn - 10));
        }

        $nonceStr = RandomUtils::randString();
        $timestamp = time();
        $string = "jsapi_ticket=$jsTicketToken&noncestr=$nonceStr&timestamp=$timestamp&url=$url";
        $signatureString = sha1($string);

        return [
            'debug' => DevEnvUtils::isDevelopEnv(),
            'appId' => WxUtils::getAppId(),
            'nonceStr' => $nonceStr,
            'timestamp' => $timestamp,
            'signature' => $signatureString,
            'jsApiList' => [
                'checkJsApi',
                'onMenuShareTimeline',
                'onMenuShareAppMessage',
                /*
                'onMenuShareQQ',
                'onMenuShareWeibo',
                'onMenuShareQZone',
                'hideMenuItems',
                'showMenuItems',
                'hideAllNonBaseMenuItem',
                'showAllNonBaseMenuItem',
                'translateVoice',
                'startRecord',
                'stopRecord',
                'onVoiceRecordEnd',
                'playVoice',
                'onVoicePlayEnd',
                'pauseVoice',
                'stopVoice',
                'uploadVoice',
                'downloadVoice',
                'chooseImage',
                'previewImage',
                'uploadImage',
                'downloadImage',
                'getNetworkType',
                'openLocation',
                'getLocation',
                'hideOptionMenu',
                'showOptionMenu',
                'closeWindow',
                'scanQRCode',
                'chooseWXPay',
                'openProductSpecificView',
                'addCard',
                'chooseCard',
                'openCard'
                */
            ]
        ];
    }

}