<?php
/**
 * Created by PhpStorm.
 * User: luowen
 * Date: 2017/3/24
 * Time: 22:29
 */

namespace App\Service\Api;


use App\Model\VisitLog;
use App\Service\BaseService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MerchantActsService extends BaseService
{
    protected  $modelClassMap = \App\Model\MerchantActs::class;


    /**
     * get start activity information
     *
     * @param Request $request
     * @return mixed
     */
    public function getStartActs(Request $request)
    {
        $session = $request -> getSession();
        $userInfo = $session -> get('_userinfo');
        $merchantId = $userInfo['id'] ? : 0;
        $pageSize = $request -> input('pageSize');
        $now = Carbon::now();
        $resultSet = $this -> where([ 'merchant_id' => $merchantId])
            -> where('act_start_time', '<=', $now)
            -> where('act_end_time', '>=', $now)
            -> orderBy('id', 'desc')
            -> paginate($pageSize);

        $items = $resultSet -> getCollection();
        $newItems = $items -> map(function ($item, $key) {
            $item = $item -> toArray();
            $actId = $item['id'];
            $rankSrv = new ActivityRankService();
            $item['join_count'] = $joinCount = $rankSrv -> getJoinCount($actId);
            $item['completed_count'] = $completedCount = $rankSrv -> getIsCompletedCount($actId);
            $item['visit_count'] = $visitCount = (new VisitLogService()) -> getVisitCount($actId);
            $item['join_proportion'] = number_format(($joinCount / (($visitCount == 0) ? 1 : $visitCount)) * 100, 2, '.', '');
            $item['completed_proportion'] = number_format(($completedCount / (($joinCount == 0) ? 1 : ($visitCount == 0) ? 1 : $visitCount)) * 100, 2, '.', '');
            return $item;
        });

        $resultSet -> setCollection($newItems);
        return $resultSet;
    }

    /**
     *  get user history activity information
     *
     * @param Request $request
     * @return mixed
     */
    public function getEndActs(Request $request)
    {
        $session = $request -> getSession();
        $userInfo = $session -> get('_userinfo');
        $merchantId = $userInfo['id'] ? : 0;
        $pageSize = $request -> input('pageSize');
        $now = Carbon::now();
        $resultSet = $this -> where([ 'merchant_id' => $merchantId])
            -> where('act_end_time', '<=', $now)
            -> orderBy('id', 'desc')
            -> paginate($pageSize);

        $items = $resultSet -> getCollection();
        $newItems = $items -> map(function ($item, $key) {
            $item = $item -> toArray();
            $actId = $item['id'];
            $rankSrv = new ActivityRankService();
            $item['join_count'] = $joinCount = $rankSrv -> getJoinCount($actId);
            $item['completed_count'] = $completedCount = $rankSrv -> getIsCompletedCount($actId);
            $item['visit_count'] = $visitCount = (new VisitLogService()) -> getVisitCount($actId);
            $item['join_proportion'] = number_format(($joinCount / (($visitCount == 0) ? 1 : $visitCount)) * 100, 2, '.', '');
            $item['completed_proportion'] = number_format(($completedCount / (($joinCount == 0) ? 1 : ($visitCount == 0) ? 1 : $visitCount)) * 100, 2, '.', '');
            return $item;
        });

        $resultSet -> setCollection($newItems);
        return $resultSet;
    }
}