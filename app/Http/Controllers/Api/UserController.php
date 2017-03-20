<?php
/**
 * Created by PhpStorm.
 * User: luowen
 * Date: 2017/3/12
 * Time: 21:43
 */

namespace App\Http\Controllers\Api;




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
        dd('User');
    }

    public function login(Request $request)
    {
        $this -> validate($request, [
            'mobile' => 'required',
            'password' => 'required'
        ], [
            'mobile.required' => '用户名不能为空',
            'password.required' => '密码不能为空',
        ]);

        $mobile = $request -> input('mobile');
        $password = $request -> input('password');

        $merchantRepo = (new MerchantService()) -> where(["phone" => $mobile]) -> first();
        if($merchantRepo) {
            if(md5($merchantRepo -> getAttribute("salt") . $password) === $merchantRepo -> getAttribute("password")) {
                $merchantRepo -> setAttribute("login_cnt", $merchantRepo -> getAttribute("login_cnt") + 1);
                $merchantRepo -> save();

                Auth::guard(config('auth.authType.mobile')) -> login($merchantRepo, true);
                return $this -> _sendJsonResponse("登入成功", $merchantRepo);
            }

            return $this -> _sendJsonResponse('用户名或密码错误', null, false);
        }

        return $this -> _sendJsonResponse('用户不存在', null, false);

    }

    public function register(Request $request)
    {
        $this -> validate($request, [
            'name' => 'required',
            'password' => 'required',
            'mobile' => 'required',
            'code' => 'required'
        ], [
            'name.required' => "用户名不能为空",
            'password.required' => '密码不能为空',
            'mobile.required' => '手机号不能为空',
            "code.required" =>  "验证码不能为空",
        ]);

        $name = $request -> input("name");
        $mobile = $request -> input("mobile");
        $password = $request -> input("password");
        $code = $request -> input("code");
        if($code == Cache::get("_captcha_" . $mobile)) {
            Cache::forget("_captcha_".$mobile); // remove cache
            $merchantRepo = ((new MerchantService()) -> where("phone", "=", $mobile) -> first()) ?
                : (new MerchantService());
            $merchantRepo -> fill([
                'name' => $name,
                'phone' => $mobile,
                'password' => md5($code.$password),
                'salt' => $code
            ]) -> save();
            return $this -> _sendJsonResponse("注册成功", ['id' => $merchantRepo -> getAttribute("id")]);
        }
        return $this -> _sendJsonResponse("验证码错误", null, false);
    }

    public function captcha(Request $request)
    {
        $this -> validate($request, [
            'mobile' => 'required|unique:merchant,phone'
        ], [
            'mobile.required' => '手机好不能为空',
            'mobile.unique' => '手机号已经注册, 请登入'
        ]);


        $mobile = $request -> input("mobile");
        if(Cache::get("_captcha_".$mobile)) {
            return $this -> _sendJsonResponse("验证码已经发送, 请耐心等待", null, false);
        }
        if($mobile) {
            $randomCode = rand(100000, 999999);
            // just for test
            Cache::put("_captcha_".$mobile, $randomCode, Carbon::now() -> addMinute(1));
            return $this -> _sendJsonResponse("验证码发送成功, 请注意查收".$randomCode);
            $resultSet = SMSUtil::send($mobile, $randomCode);

            if($resultSet && is_array($resultSet) && isset($resultSet['code']) && $resultSet['code'] == 2) {
                Cache::put("_captcha_".$mobile, $randomCode, Carbon::now() -> addMinute(1));
                return $this -> _sendJsonResponse("验证码发送成功, 请注意查收");
            }
            Log::error("captcha code send failed", $resultSet);
            return $this -> _sendJsonResponse("系统繁忙, 请稍候再试", null, false);
        }
        return $this -> _sendJsonResponse('请输入正确的手机号码',null, false);
    }
}