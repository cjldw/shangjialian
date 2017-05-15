<?php
/**
 * Created by PhpStorm.
 * User: luowen
 * Date: 2017/3/12
 * Time: 21:45
 */

namespace App\Http\Controllers\Api;


use App\Service\Api\ActivityRankService;
use App\Service\Api\MerchantActsService;
use App\Service\Api\VisitLogService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MineController extends BaseController
{

    /**
     * get top one activity information
     *
     * @param Request $request
     * @return $this|\Illuminate\Http\JsonResponse
     */
    public function top1(Request $request)
    {
        $session = $request -> getSession();
        $id = $session -> get("_userinfo")["id"];
        $resultSet = (new MerchantActsService()) -> where([
            "merchant_id" => $id
        ]) -> orderBy("id", "desc") -> first();

        if(is_null($resultSet)) {
            return $this -> _sendJsonResponse("用户没有数据", null, false);
        }

        $actId = $resultSet -> getAttribute("id");

        $rankSrv = new ActivityRankService();
        $joinCount = $rankSrv -> getJoinCount($actId);
        $completedCount = $rankSrv -> getIsCompletedCount($actId);
        $visitCount = (new VisitLogService()) -> getVisitCount($actId);

        $resultSet = array_merge($resultSet -> toArray(), [
            'join_cnt' => $joinCount,
            'completed_cnt' => $completedCount,
            'visit_cnt' => $visitCount,
            'join_proportion' => number_format(($joinCount / (($visitCount == 0) ? 1 : $visitCount)) * 100, 2, '.', ''),
            'completed_proportion' => number_format(($completedCount / (($joinCount == 0) ? 1 : ($visitCount == 0) ? 1 : $visitCount)) * 100, 2, '.', '')
        ]);
        return $this -> _sendJsonResponse("请求成功", $resultSet);
    }

    /**
     * activity is started. very important
     *
     * @param Request $request
     * @return $this|\Illuminate\Http\JsonResponse
     */
    public function start(Request $request)
    {
        $resultSet = (new MerchantActsService()) -> getStartActs($request);
        return $this -> _sendJsonResponse("请求成功", $resultSet);
    }

    /**
     * nostart activity list
     *
     * @param Request $request
     * @return $this|\Illuminate\Http\JsonResponse
     */
    public function nostart(Request $request)
    {
        $session = $request -> getSession();
        $userInfo = $session -> get("_userinfo");
        $merchantId = $userInfo['id'];
        $pageSize = $request -> input("pageSize");

        $now = Carbon::now();
        $resultSet = (new MerchantActsService())
            -> where([ 'merchant_id' => $merchantId])
            -> where("act_start_time", ">=", $now)
            -> orderBy('id', 'desc')
            -> paginate($pageSize);

        return $this -> _sendJsonResponse("请求成功", $resultSet);
    }

    /**
     * get action execute
     *
     * @param Request $request
     * @return $this|\Illuminate\Http\JsonResponse
     */
    public function end(Request $request)
    {
        $resultSet = (new MerchantActsService()) -> getEndActs($request);
        return $this -> _sendJsonResponse("请求成功", $resultSet);
    }

    /**
     * get completed activity by user phone
     *
     * @param Request $request
     * @return $this|\Illuminate\Http\JsonResponse
     */
    public function getPrizeList(Request $request)
    {
        $this -> validate($request, [
            'mobile' => 'required',
        ], [
            'mobile.required' => '请输入用户手机号码',
        ]);

        $session = $request -> getSession();
        $userInfo = $session -> get('_userinfo');
        $merchantId = isset($userInfo['id']) ? $userInfo['id'] : 0;

        $mobile = $request -> input('mobile');
        $rankRepo = (new ActivityRankService()) -> where([
            'phone' => $mobile,
        ]) -> get();
        if($rankRepo -> isEmpty()) {
            return $this -> _sendJsonResponse('请求成功', $rankRepo);
        }

        $actIds = array_column($rankRepo -> toArray(), 'act_id');
        $activityRepo = (new MerchantActsService()) -> where('merchant_id', $merchantId)
            -> whereIn('id', $actIds) -> get();
        return $this -> _sendJsonResponse('请求成功', $activityRepo);
    }

    /**
     * user exchange merchant gifts
     *
     * @param Request $request
     * @return $this|\Illuminate\Http\JsonResponse
     */
    public function exchange(Request $request)
    {
        $this -> validate($request, [
            'mobile' => 'required',
            'actId' => 'required',
        ], [
            'mobile.required' => '手机号不能为空',
            'actId.required' => '活动id不能为空',
        ]);

        $mobile = $request -> input('mobile');
        $actId = $request -> input('actId');

        $rankRepo = (new ActivityRankService()) -> where([
            'phone' => $mobile,
            'act_id' => $actId
        ]) -> first();

        if(!$rankRepo) {
            return $this -> _sendJsonResponse('活动不存在', null, false);
        }

        $isCompleted = $rankRepo -> getAttribute('is_completed');
        if(!$isCompleted) {
            return $this -> _sendJsonResponse('您未完成次活动, 不能兑换', null, false);
        }

        $isExchanged = $rankRepo -> getAttribute('is_exchanged');
        if($isExchanged) {
            return $this -> _sendJsonResponse('您已经领取过此活动的奖品', null, false);
        }
        $rankRepo -> setAttribute('is_exchanged', 1);
        if(!$stat = $rankRepo -> save()){
            return $this -> _sendJsonResponse('网络繁忙, 请稍候再试试', null, false);
        }

        return $this -> _sendJsonResponse('领取成功, 记得发放奖品给用户哦');
    }

}