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

        $resultSet = (new ActivityRankService()) -> where([
            'act_id' => $actId,
            'openid' => $openid
        ]) -> first();

        if($resultSet) {
            return $this -> _sendJsonResponse("请求成功", $resultSet);
        }
        return $this -> _sendJsonResponse("用户不存在", null, false);

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

        /* 用户分享后, 自己打开, 什么也不做 */
        if($userInfo['openid'] == $openid) {
            return $this -> _sendJsonResponse("自己不能帮助自己", null, false);
        }

        $rankRepo = (new ActivityRankService()) -> where([
            'openid' => $openid,
            'act_id' => $actId
        ]) -> first();

        $rankRepo = $rankRepo ? : (new ActivityRankService());

        $helpers = json_decode($rankRepo -> getAttribute("helpers"), true);
        if(is_array($helpers) && in_array($openid, $helpers)) {
            return $this -> _sendJsonResponse("请求成功", ['msg' => '之前已经帮忙了']);
        }

        if(is_array($helpers)) { // append current openid in helpers
            array_push($helpers, $openid);
        }
        $helpers = [$openid];

        $joinCnt = $rankRepo -> getAttribute("join_cnt");
        $rankRepo -> setAttribute("join_cnt", ++$joinCnt);
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

}