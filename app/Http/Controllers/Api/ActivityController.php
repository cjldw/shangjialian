<?php
/**
 * Created by PhpStorm.
 * User: luowen
 * Date: 2017/3/12
 * Time: 21:46
 */

namespace App\Http\Controllers\Api;


use App\Service\Api\ActivityService;
use Illuminate\Http\Request;

class ActivityController extends BaseController
{

    public function index()
    {

    }

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
        $resultSet = (new ActivityService())  -> orderBy("id", "desc")
            -> orderBy("is_recommend", "desc") -> limit(6) -> get();

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

}