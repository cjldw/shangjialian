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
            'merchant_id' => $userInfo["id"],
            'openid' => $userInfo['openid'],
        ];
        $attributes = array_merge($userData, $request -> all());
        $merchantActsRepo = new MerchantActsService();
        $merchantActsRepo -> fill($attributes) -> save();
        return $this -> _sendJsonResponse("创建成功", ['id' => $merchantActsRepo -> getAttribute("id")]);
    }

    /**
     * delete user activity by id
     *
     * @param Request $request
     * @param $id
     * @return $this|\Illuminate\Http\JsonResponse
     */
    public function deleteById(Request $request, $id)
    {
        $merchantActRepo = (new MerchantActsService()) -> find($id);

        if($merchantActRepo) {
            $merchantActRepo -> delete();
            return $this -> _sendJsonResponse("删除成功", ['id' => $id]);
        }
        return $this -> _sendJsonResponse("活动不存在");

    }

    public function updateById(Request $request, $id)
    {

    }

}