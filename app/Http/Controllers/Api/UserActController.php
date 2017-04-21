<?php
/**
 * Created by PhpStorm.
 * User: luowen
 * Date: 2017/3/23
 * Time: 21:35
 */

namespace App\Http\Controllers\Api;


use App\Service\Api\ActivityRankService;
use App\Service\Api\ActivityService;
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
        $tplData = $request -> all();
        $tplData['tpl_id'] = isset($tplData['id']) ? $tplData['id'] : 1;
        $attributes = array_merge($userData, $tplData);
        $merchantActsRepo = new MerchantActsService();
        $merchantActsRepo -> fill($attributes) -> save();

        $merchantRankRepo = new ActivityRankService();
        $merchantRankRepo -> fill([
            'act_id' => $merchantActsRepo -> getAttribute("id"),
            'openid' => $userInfo['openid'],
            'merchant_id' => $userInfo['id'],
            'name' => $userInfo['name'],
            'phone' => $userInfo['phone'],
            'completed_cnt' => $merchantActsRepo -> getAttribute("act_rule_cnt"),
        ]) -> save();

        /* 模版使用次数+1 */
        if($actRepo = (new ActivityService()) -> find($tplData['id'])) {
            $bizmanCopyCnt = $actRepo -> getAttribute('bizman_copy_cnt');
            $actRepo -> setAttribute('bizman_copy_cnt', ++$bizmanCopyCnt);
            $actRepo -> save();
        }

        return $this -> _sendJsonResponse("创建成功", [
            'id' => $merchantActsRepo -> getAttribute("id"),
            'openid' => $userInfo['openid']
        ]);
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

    /**
     * update user's activity
     *
     * @param Request $request
     * @param $id
     * @return $this|\Illuminate\Http\JsonResponse
     */
    public function updateById(Request $request, $id)
    {
        $userActRepo = (new MerchantActsService()) -> find($id);
        if($userActRepo) {
            $requestAttribute = $request -> all();
            $userActRepo -> fill($requestAttribute) -> save();
            return $this -> _sendJsonResponse("保存成功", $requestAttribute);
        }
        return $this -> _sendJsonResponse("活动不存在", ['id' => $id], false);

    }

}