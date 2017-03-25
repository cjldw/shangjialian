<?php
/**
 * Created by PhpStorm.
 * User: luowen
 * Date: 2017/3/23
 * Time: 21:35
 */

namespace App\Http\Controllers\Api;


use App\Service\Api\MerchantActsService;
use Illuminate\Http\Request;

class UserActController extends BaseController
{

    public function createAct(Request $request)
    {
        $session = $request -> getSession();
        $userInfo = $session -> get("_userinfo");
        $userData = [
            'merchant_id' => $userInfo -> getAttribute("id"),
            'openid' => $userInfo -> getAttribute("openid"),
        ];
        $attributes = array_merge($userData, $request -> all());
        $merchantActsRepo = new MerchantActsService();
        $merchantActsRepo -> fill($attributes) -> save();
        return $this -> _sendJsonResponse("创建成功", ['id' => $merchantActsRepo -> getAttribute("id")]);
    }

    public function deleteById(Request $request, $id)
    {

    }

    public function updateById(Request $request, $id)
    {

    }

}