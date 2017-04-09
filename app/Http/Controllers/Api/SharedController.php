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
use App\Service\Api\MerchantService;
use App\Service\Api\VisitLogService;
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

    /**
     * 获取用户分享的活动信息
     *
     * @param Request $request
     * @param $id
     * @return $this|\Illuminate\Http\JsonResponse
     */
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

    /**
     * 获取分享的活动的用户已经点赞的数量
     *
     * @param Request $request
     * @return $this|\Illuminate\Http\JsonResponse
     */
    public function getUserInfo(Request $request)
    {
        $this -> validate($request, [
            'actId' => 'required',
            'openid' => 'required'
        ], [
            'actId.required' => '活动id不能为空',
            'openid.required' => '微信openid不能为空'
        ]);

        $actId = $request -> input("actId");
        $openid = $request -> input("openid");

        $merchantRepo = (new MerchantService()) -> where([
            'openid' => $openid
        ]) -> first();

        $merchantName = $merchantRepo ? $merchantRepo -> getAttribute("name") : "";

        $resultSet = (new ActivityRankService()) -> where([
            'act_id' => $actId,
            'openid' => $openid
        ]) -> first();

        if(!$resultSet) {
            $resultSet = [
                'join_cnt' => 0,
                'completed_cnt' => 1,
                'is_completed' => 0,
                'spend_time' => '还差一点点',
                'username' => $merchantName,
            ];
        } else {
            $resultSet = $resultSet -> toArray();
            $resultSet['username'] = $merchantName;
        }
        return $this -> _sendJsonResponse("请求成功", $resultSet);
    }

    /**
     * 微信朋友打开页面自动帮忙点赞了
     *
     * @param Request $request
     * @return $this|\Illuminate\Http\JsonResponse
     */
    public function helpIt(Request $request)
    {

        $this -> validate($request, [
            'actId' => 'required',
            'openid' => 'required'
        ], [
            'actId.required' => '活动id不能为空',
            'openid.required' => '微信openid不能为空'
        ]);

        $actId = $request -> input("actId");
        $openid = $request -> input("openid");


        $session = $request -> getSession();
        $userInfo = $session -> get("_userinfo");
        $helperId = $userInfo['openid'];

        /* 用户分享后, 自己打开, 什么也不做 */
        if($helperId == $openid) {
            return $this -> _sendJsonResponse("自己不能帮助自己", null, false);
        }

        $rankRepo = (new ActivityRankService()) -> where([
            'openid' => $openid,
            'act_id' => $actId
        ]) -> first();

        if(!$rankRepo) {
            return $this -> _sendJsonResponse("分享连接出错", null, false);
        }

        $helpers = json_decode($rankRepo -> getAttribute("helpers"), true);
        if(is_array($helpers) && in_array($helperId, $helpers)) {
            return $this -> _sendJsonResponse("请求成功", ['msg' => '之前已经帮忙了']);
        }

        if(is_array($helpers)) { // append current openid in helpers
            array_push($helpers, $helperId);
        }
        $helpers = [$helperId];


        $joinCnt = $rankRepo -> getAttribute("join_cnt");
        $completedCnt = $rankRepo -> getAttribute("completed_cnt");
        $nowJoinCnt = $joinCnt + 1;
        /* mark as completed */
        if($nowJoinCnt >= $completedCnt) {
            $rankRepo -> setAttribute("is_completed", 1);
        }

        $rankRepo -> setAttribute("join_cnt", $nowJoinCnt);
        $rankRepo -> setAttribute("helpers", json_encode($helpers, JSON_UNESCAPED_UNICODE));
        $rankRepo -> setAttribute("act_id", $actId);
        $rankRepo -> save();

        return $this -> _sendJsonResponse("请求成功", ['msg' => "帮忙成功"]);
    }


    /**
     * 用户是否已经参与过活动
     *
     * @param Request $request
     * @return $this|\Illuminate\Http\JsonResponse
     */
    public function isPlay(Request $request)
    {
        $this -> validate($request, [
            'openid' => 'required',
            'actId' => 'required',
        ], [
            'openid.required' => 'openid不能为空',
            'actId.required' => 'actId不能为空',
        ]);

        $actId = $request -> input("actId");
        $openid = $request -> input("openid");

        $resultSet = (new ActivityRankService()) -> where([
            'openid' => $openid,
            'act_id' => $actId
        ]) -> first();

        if($resultSet) {
            return $this -> _sendJsonResponse('用户之前有参与此活动', $resultSet);
        }
        return $this -> _sendJsonResponse("用户没有参与", null, false);
    }

    /**
     * user join activity
     *
     * @param Request $request
     * @return $this|\Illuminate\Http\JsonResponse
     */
    public function play(Request $request)
    {
        $id = $request -> input("id", false);
        $name = $request -> input("name", false);
        $phone = $request -> input("phone", false);

        $this -> validate($request, [
            'actOpenId' => 'required',
        ], [
            'actOpenId.required' => '活动openid不能为空'
        ]);

        $rankRepo = new ActivityRankService();
        /* first play fill necessary information */
        if(!$rankRepo -> find($id)) {

            $this -> validate($request -> all(), [
                'actId' => 'required',
                'openid' => 'required',
            ], [
                'actId.required' => 'actId不能为空',
                'openid.required' => 'openid不能为空'
            ]);

            $actId = $request -> input("actId");
            $openid = $request -> input("openid");
            $actOpenId = $request -> input("actOpenId");

            $rankRepo -> setAttribute("act_id", $actId);
            $rankRepo -> setAttribute("openid", $openid);
            $rankRepo -> setAttribute("level", (($openid == $actOpenId) ? 0 : 1));

            /* query activity complement count rule */
            $merchantAct = (new MerchantActsService()) -> find($actId);
            $ruleCnt = $merchantAct -> getAttribute("act_rule_cnt");
            $rankRepo -> setAttribute("completed_cnt", $ruleCnt);
        }
        if($name) {
            $rankRepo -> setAttribute("name", $name);
        }
        if($phone) {
            $rankRepo -> setAttribute("phone", $phone);
        }
        $rankRepo -> save();

        return $this -> _sendJsonResponse("参与成功", $request -> all());
    }

    /**
     * record user visit log
     *
     * @param Request $request
     * @return $this|\Illuminate\Http\JsonResponse
     */
    public function visitLog(Request $request)
    {
        $this -> validate($request, [
            'actId' => 'required',
            'openid' => 'required',
            'merchantId' => 'required',
        ], [
            'actId.required' => '活动id不能为空',
            'openid.required' => 'openid不能为空',
            'merchantId.required' => 'merchantId不能为空'
        ]);

        $visitLogRepo = new VisitLogService();
        $visitLogRepo -> fill($request -> all()) -> save();
        return $this -> _sendJsonResponse('请求成功', $visitLogRepo);
    }

}