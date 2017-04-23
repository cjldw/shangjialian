<?php
/**
 * Created by PhpStorm.
 * User: luowen
 * Date: 2017/3/12
 * Time: 21:43
 */

namespace App\Http\Controllers\Api;

use App\Utils\DevEnvUtils;
use Auth;
use Cache;
use App\Utils\SMSUtil;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Service\Api\MerchantService;

class UserController extends BaseController
{

    public function index(Request $request)
    {
        $session = $request -> getSession();
        $userInfo = $session -> get("_userinfo");
        return $this -> _sendJsonResponse($userInfo);
    }

    public function login(Request $request)
    {
        $this -> validate($request, [
            'mobile' => 'required',
            'password' => 'required',
            'openid' => 'required',
        ], [
            'mobile.required' => '用户名不能为空',
            'password.required' => '密码不能为空',
            'openid.required' => '网络繁忙, 请稍候在试',
        ]);

        $mobile = $request -> input('mobile');
        $password = $request -> input('password');
        $openid = $request -> input('openid');
        $merchantRepo = (new MerchantService()) -> where(["phone" => $mobile, 'openid' => $openid]) -> first();
        if($merchantRepo) {
            if(md5($merchantRepo -> getAttribute("salt") . $password) === $merchantRepo -> getAttribute("password")) {
                $merchantRepo -> setAttribute("login_cnt", $merchantRepo -> getAttribute("login_cnt") + 1);
                $merchantRepo -> save();
                //Auth::guard(config('auth.authType.mobile')) -> login($merchantRepo, true);
                $session = $request -> getSession();
                $session -> put("_userinfo", $merchantRepo -> toArray());
                $session -> save();
                return $this -> _sendJsonResponse("登入成功", [
                    'name' => $merchantRepo -> getAttribute("name"),
                    'mobile' => $merchantRepo -> getAttribute("phone"),
                    'expiredDays' => $merchantRepo -> getExpiredDays(),
                ]);
            }
            return $this -> _sendJsonResponse('用户名或密码错误', null, false);
        }
        return $this -> _sendJsonResponse('用户不存在', null, false);

    }

    /**
     * logout
     *
     * @param Request $request
     * @return $this|\Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $session = $request -> getSession();
        $session -> flush();
        Auth::guard(config("auth.authType.mobile")) -> logout();
        return $this -> _sendJsonResponse('退出成功!', ['redirectUrl' => "/"]);
    }

    public function bindmobile(Request $request)
    {
        /* just for test */
        $session = $request -> getSession();
        $openid = $session -> get("_userinfo")['openid'];
        $merchantRepo = (new MerchantService()) -> where("openid", "=", $openid) -> first();

        if($merchantRepo && $merchantRepo -> getAttribute("mobile")) {
            return $this -> _sendJsonResponse("你的微信号已经使用手机注册了", null, false);
        }

        $this -> validate($request, [
            'name' => 'required',
            'mobile' => 'required',
            'code' => 'required',
            'password' => 'required',
        ], [
            'name.required' => "用户名不能为空",
            'mobile.required' => '手机号不能为空',
            "code.required" =>  "验证码不能为空",
            'password.required' => '密码不能为空',
        ]);

        $name = $request -> input("name");
        $mobile = $request -> input("mobile");
        $password = $request -> input("password");
        $code = $request -> input("code");

        if(DevEnvUtils::isDevelopEnv() || $code == Cache::get("_captcha_" . $mobile)) {
            //Cache::forget("_captcha_".$mobile); // remove cache
            if($merchantRepo) {
                $merchantRepo -> fill([
                    'name' => $name,
                    'phone' => $mobile,
                    'password' => md5($code.$password),
                    'salt' => $code
                ]) -> save();
                $expiredDays = $merchantRepo -> getExpiredDays();
                $respData = [
                    'mobile' => $mobile,
                    'name' => $name,
                    'expiredDays' =>  $expiredDays,
                    'isAvailable' => ($expiredDays > 0) ? : false,
                ];
                return $this -> _sendJsonResponse("绑定成功", $respData);
            }
            return $this -> _sendJsonResponse("你是黑客吗?", $request -> all(), false);
        }
        return $this -> _sendJsonResponse("验证码错误", null, false);
    }

    public function captcha(Request $request)
    {
        $this -> validate($request, [
            'mobile' => 'required|unique:merchant,phone'
        ], [
            'mobile.required' => '手机号不能为空',
            'mobile.unique' => '次手机号已经注册, 请确认后再注册!'
        ]);


        $mobile = $request -> input("mobile");
        if(Cache::get("_captcha_".$mobile)) {
            return $this -> _sendJsonResponse("验证码已经发送, 请耐心等待", null, false);
        }
        if($mobile) {

            $session = $request -> getSession();
            $openid = $session -> get("_userinfo")['openid'];
            $isBind = (new MerchantService()) -> where(['openid' => $openid, 'phone' => $mobile]) -> first();
            if($isBind) {
                return $this -> _sendJsonResponse("用户已经绑定了手机号, 不能在绑定, 如需修改, 联系客服", $request -> all(), false);
            }


            $randomCode = rand(100000, 999999);
            // just for test
            Cache::put("_captcha_".$mobile, $randomCode, Carbon::now() -> addMinute(1));
            if(DevEnvUtils::isDevelopEnv()) {
                return $this -> _sendJsonResponse("验证码发送成功, 请注意查收".$randomCode, ['code' => $randomCode]);
            }
            $resultSet = SMSUtil::send($mobile, $randomCode);

            if($resultSet && is_array($resultSet) && isset($resultSet['code']) && $resultSet['code'] == 2) {
                Cache::put("_captcha_".$mobile, $randomCode, Carbon::now() -> addMinute(1));
                return $this -> _sendJsonResponse("验证码发送成功, 请注意查收", ['code' => '']);
            }
            Log::error("captcha code send failed", $resultSet);
            return $this -> _sendJsonResponse("系统繁忙, 请稍候再试", null, false);
        }
        return $this -> _sendJsonResponse('请输入正确的手机号码',null, false);
    }

    /**
     * reset password
     *
     * @param Request $request
     * @return $this|\Illuminate\Http\JsonResponse
     */
    public function resetpwd(Request $request)
    {
        $this -> validate($request, [
            'password' => 'required'
        ], [
            'password.required' => '新密不能为空'
        ]);

        $session = $request -> getSession();
        $phone = $session -> get("_canset_pwd");
        $password = $request -> input("password");
        if($phone) {
            $merchantRepo = (new MerchantService()) -> where([
                'phone' => $phone
            ]) -> first();

            if($merchantRepo) {
                $newPassword = md5($merchantRepo -> getAttribute("salt") . $password);
                $merchantRepo -> setAttribute("password", $newPassword);
                $merchantRepo -> save();

                return $this -> _sendJsonResponse("设置成功");
            }
        }
        return $this -> _sendJsonResponse("设置失败, 请重新获取验证码", [$password], false);
    }

    /**
     * check captcha code
     *
     * @param Request $request
     * @return $this|\Illuminate\Http\JsonResponse
     */
    public function verifyResetPwdCaptchaCode(Request $request)
    {
        $this -> validate($request, [
            'phone' => 'required',
            'code' => 'required',
        ], [
            'phone.required' => '手机号不能为空',
            'code.required' => '验证码不能为空'
        ]);

        $phone = $request -> input("phone");
        $code = $request -> input("code");

        if($cacheCode = Cache::get("_captcha_pwd_".$phone)) {
            if($cacheCode == $code) {
                $session = $request -> getSession();
                $session -> put("_canset_pwd", $phone);
                $session -> save();
                return $this -> _sendJsonResponse("验证成功");
            }
        }
        return $this -> _sendJsonResponse("验证码错误", $request -> all(), false);
    }

    /**
     * get captcha code
     *
     * @param Request $request
     * @return $this|\Illuminate\Http\JsonResponse
     */
    public function getResetPwdCaptcha(Request $request)
    {
        $this -> validate($request, [
            'phone' => 'required',
        ], [
            'phone.required' => '手机号不能为空',
        ]);

        $phone = $request -> input("phone");
        $merchantRepo = (new MerchantService()) -> where(['phone' => $phone]) -> first();
        if(!$merchantRepo) {
            return $this -> _sendJsonResponse("用户不存在, 请注册", ['phone' => $phone], false);
        }

        if(Cache::get("_captcha_pwd_".$phone)) {
            return $this -> _sendJsonResponse("验证码已经发送, 请耐心等待", null, false);
        }
        $randomCode = rand(100000, 999999);
        // just for test
        Cache::put("_captcha_pwd_".$phone, $randomCode, Carbon::now() -> addMinute(1));
        if(DevEnvUtils::isDevelopEnv()) {
            return $this -> _sendJsonResponse("验证码发送成功, 请注意查收".$randomCode, ['code' => $randomCode]);
        }
        $resultSet = SMSUtil::send($phone, $randomCode);
        if($resultSet && is_array($resultSet) && isset($resultSet['code']) && $resultSet['code'] == 2) {
            Cache::put("_captcha_pwd_".$phone, $randomCode, Carbon::now() -> addMinute(1));
            return $this -> _sendJsonResponse("验证码发送成功, 请注意查收", ['code' => '']);
        }
        Log::error("captcha code send failed", $resultSet);
        return $this -> _sendJsonResponse("系统繁忙, 请稍候再试", null, false);
    }

    /**
     * 获取用户登入状态
     *
     * @param Request $request
     * @return $this|\Illuminate\Http\JsonResponse
     */
    public function loginInfo(Request $request)
    {
        $session = $request -> getSession();
        $userInfo = $session -> get("_userinfo");
        if(!$userInfo || !is_array($userInfo)) {
            return $this -> _sendJsonResponse("用户未登入", [], false);
        }
        if(!isset($userInfo['id'])) {
            return $this -> _sendJsonResponse("用户未登入", [], false);
        }

        $merchantRepo = (new MerchantService()) -> find($userInfo['id']);
        if(!$merchantRepo) {
            return $this -> _sendJsonResponse("用户不存在", [], false);
        }

        if(trim($merchantRepo -> getAttribute("phone")) == '') {
            return $this -> _sendJsonResponse("用户未注册", [], false);
        }

        $session -> put("_userinfo", $merchantRepo -> toArray());
        $session -> save();
        return $this -> _sendJsonResponse("请求成功", [
            'name' => $merchantRepo -> getAttribute("name"),
            'mobile' => $merchantRepo -> getAttribute("phone"),
            'expiredDays' => $merchantRepo -> getExpiredDays(),
        ]);
    }

}