<?php
/**
 * Created by PhpStorm.
 * User: luowen
 * Date: 2017/3/4
 * Time: 15:13
 */

namespace App\Http\Controllers\Backend;


use Auth;
use App\Model\PcUser;
use Illuminate\Auth\Authenticatable;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    protected $subViewPath = "user";


    public function login(Request $request)
    {
        if(strtolower($request -> getMethod()) == 'post') {
            $this -> validate($request, [
                'username' => 'required',
                'password' => 'required'
            ]);

            $username = $request -> input("username");
            $password = $request -> input("password");

            $user = (new PcUser()) -> where(['name' => $username]) -> first();
            if($user && $user -> getAttribute('password') === md5($password . $user -> getAttribute("salt"))) {
                $isRememberMe = $request -> input("rememberMe") ?  true : false;
                Auth::guard(config('auth.authType.pc')) -> login($user, $isRememberMe);
                return $this -> _sendJsonResponse("登入成功", $user);
            }
            return $this -> _sendJsonResponse('用户名或密码错误', [], false);
        }
        return $this -> _sendViewResponse("login");
    }

    public function logout(Request $request)
    {
        Auth::guard(config("auth.authType.pc")) -> logout();
        return $this -> _sendJsonResponse('退出成功!', ['redirectUrl' => "/admin/login"]);
    }

}