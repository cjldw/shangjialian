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

        $actId = $resultSet -> getAttribute("id");

        $rankSrv = new ActivityRankService();
        $joinCount = $rankSrv -> getJoinCount($actId);
        $completedCount = $rankSrv -> getIsCompletedCount($actId);
        $visitCount = (new VisitLogService()) -> getVisitCount($actId);

        $resultSet = array_merge($resultSet -> toArray(), [
            'join_cnt' => $joinCount,
            'completed_cnt' => $completedCount,
            'visit_cnt' => $visitCount,
            'join_proportion' => ($joinCount / (($visitCount == 0) ? 1 : $visitCount)) * 100,
            'completed_proportion' => ($completedCount / (($joinCount == 0) ? 1 : ($visitCount == 0) ? 1 : $visitCount)) * 100
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



}