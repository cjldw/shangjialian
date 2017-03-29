<?php
/**
 * Created by PhpStorm.
 * User: luowen
 * Date: 2017/3/28
 * Time: 22:58
 */

namespace App\Http\Controllers\Api;


use App\Service\Api\ActivityRankService;
use App\Service\Api\MerchantActsService;
use Illuminate\Http\Request;

class SharedController extends BaseController
{

    /**
     * query act rank top
     *
     * @param Request $request
     * @param $id
     * @return $this|\Illuminate\Http\JsonResponse
     */
    public function getActRank(Request $request, $id)
    {
        $pageSize = $request -> input("pageSize");
        $actRankRepo = new ActivityRankService();
        $resultSet = $actRankRepo -> where("act_id", "=", $id)
            -> orderBy("join_cnt", 'desc') -> orderBy("id", 'desc')
            -> paginate($pageSize);

        return $this -> _sendJsonResponse("请求成功", $resultSet);
    }

    public function sharedAct(Request $request, $id)
    {
        $resultSet = (new MerchantActsService()) -> where([
            'id' => $id
        ]) -> first();

        if($resultSet) {
            return $this -> _sendJsonResponse("请求成功", $resultSet);
        }
        return $this -> _sendJsonResponse("活动不存在");

    }

    public function getUserInfo(Request $request)
    {

    }

    public function helpIt(Request $request)
    {

        $actId = $request -> input("actId");
        $openid = $request -> input("openid");

        $session = $request -> getSession();
        $userInfo = $session -> get("_userinfo");

        /* 用户分享后, 自己打开, 什么也不做 */
        if($userInfo['openid'] == $openid) {
            return $this -> _sendJsonResponse("请求成功", ['msg' => '自己不能帮助自己']);
        }

        $rankRepo = (new ActivityRankService()) -> where([
            'openid' => $openid,
            'act_id' => $actId
        ]) -> first();

        $rankRepo = $rankRepo ? : (new ActivityRankService());

        $helpers = $rankRepo -> getAttribute("helpers");
        if($helpers && is_array($helpersArr = json_decode($helpers, true))
            && in_array("$openid", $helpersArr)) {
            return $this -> _sendJsonResponse("请求成功", ['msg' => '之前已经帮忙了']);
        }

        $joinCnt = $rankRepo -> getAttribute("join_cnt");
        $rankRepo -> setAttribute("join_cnt", ++$joinCnt);
        $helpersArr = json_decode($helpers, true);
        $helpersArr = is_array($helpersArr) ? $helpersArr : [];

        $helpersArr[] = $openid;
        $rankRepo -> setAttribute("helpers", json_encode($helpersArr, JSON_UNESCAPED_UNICODE));
        $rankRepo -> setAttribute("act_id", $actId);
        $rankRepo -> save();

        return $this -> _sendJsonResponse("请求成功", ['msg' => "帮忙成功"]);
    }


}