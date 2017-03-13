<?php
/**
 * Created by PhpStorm.
 * User: luowen
 * Date: 2017/3/12
 * Time: 21:43
 */

namespace App\Http\Controllers\Api;



use Illuminate\Http\Request;

class UserController extends BaseController
{

    public function index(Request $request)
    {
    }

    public function register(Request $request)
    {
        $username = $request -> input("username");
        $mobile = $request -> input("mobile");
        $code = $request -> input("code");

    }
}