<?php
/**
 * Created by PhpStorm.
 * User: luowen
 * Date: 2017/3/12
 * Time: 21:46
 */

namespace App\Http\Controllers\Api;


use App\Service\Api\ActivityRankService;
use App\Service\Api\ActivityService;
use Illuminate\Http\Request;

class ActivityController extends BaseController
{

    public function detail(Request $request, $id)
    {
        $resultSet = (new ActivityService()) -> find($id);
        return $this -> _sendJsonResponse('请求成功', $resultSet);
    }


    /**
     * recommend three activity
     *
     * @param Request $request
     * @return $this|\Illuminate\Http\JsonResponse
     */
    public function recommend(Request $request)
    {
        $resultSet = (new ActivityService())
            -> where("is_offshelf", '=', 0)
            -> orderBy("id", "desc")
            -> orderBy("is_recommend", "desc")
            -> limit(6)
            -> get();
        return $this -> _sendJsonResponse("请求成功", $resultSet);
    }

    /**
     * acquire activity by industry_id and paginate it.
     *
     * @param Request $request
     * @param $id
     * @return $this|\Illuminate\Http\JsonResponse
     */
    public function industry(Request $request, $id)
    {
        $pageSize = $request -> input("pageSize");
        $like = $request -> input("like");
        $builder = (new ActivityService()) -> orderBy("id", 'desc')
            -> where(["industry_id" => $id]);

        if($like != '') {
            $builder = $builder -> where("title", 'like', '%'.$like.'%');
        }
        $resultSet = $builder -> paginate($pageSize);

        return $this -> _sendJsonResponse('请求成功', $resultSet);

    }

    /**
     * get default rank of activity
     *
     * @param Request $request
     * @return $this|\Illuminate\Http\JsonResponse
     */
    public function getDefaultRank(Request $request)
    {
        $pageSize = $request -> input("pageSize");

        $resultSet = (new ActivityRankService()) -> where([
            'act_id' => 0,
        ]) -> orderBy('is_completed', 'desc') -> orderBy('id', 'desc') -> paginate($pageSize);

        return $this -> _sendJsonResponse("请求成功", $resultSet);
    }


    /**
     * 根据活动能够id, 获取参与人数
     *
     * @param Request $request
     * @return $this|\Illuminate\Http\JsonResponse
     */
    public function getActRank(Request $request)
    {
        $this -> validate($request, [
            'actId' => 'required',
        ], [
            'actId.required' => '活动id不能为空',
        ]);

        $session = $request -> getSession();
        $userInfo = $session -> get('_userinfo');

        $pageSize = $request -> input('pageSize');
        $actId = $request -> input('actId');

        $resultSet = (new ActivityRankService()) -> where([
            'act_id' => $actId,
            'openid' => $userInfo['openid']
        ]) -> whereNotNull('phone') -> paginate($pageSize);

        return $this -> _sendJsonResponse($resultSet);
    }
}