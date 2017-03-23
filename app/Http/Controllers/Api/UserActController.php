<?php
/**
 * Created by PhpStorm.
 * User: luowen
 * Date: 2017/3/23
 * Time: 21:35
 */

namespace App\Http\Controllers\Api;


use Illuminate\Http\Request;

class UserActController extends BaseController
{

    public function createAct(Request $request)
    {
        $session = $request -> getSession();
        $openid = $session -> get("_openid");
        return $this -> _sendJsonResponse("创建成功", ['id' => 1]);
    }

    public function deleteById(Request $request, $id)
    {

    }

    public function updateById(Request $request, $id)
    {

    }

}