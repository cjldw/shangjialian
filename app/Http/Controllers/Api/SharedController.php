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

    }



}