<?php
/**
 * Created by PhpStorm.
 * User: luowen
 * Date: 2017/3/13
 * Time: 23:06
 */

namespace App\Utils;


final class SMSUtil
{
    use SingletonTrait;

    const SMS_SERVICE_API = "http://106.ihuyi.cn/webservice/sms.php?method=Submit";
    const SMS_USER = "cf_51lianying";
    const SMS_APPKEY = "debee3af377db95e5c87345c33abf645";
    const SMS_EXPIRE = "10";
    const SMS_TEMPLATE = "您的验证码是：【%s】。请不要把验证码泄露给其他人。";

    public static function getInstance() {}

    public static function send($mobile, $code)
    {
        $postData = [
            'account' => self::SMS_USER,
            'password' => self::SMS_APPKEY,
            'format' => 'json',
            'mobile' => $mobile,
            'content' => rawurldecode(sprintf(self::SMS_TEMPLATE, $code)),
        ];
        return json_decode($contents = HttpUtil::post(self::SMS_SERVICE_API, $postData), true);
    }
}
