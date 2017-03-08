<?php
/**
 * Created by PhpStorm.
 * User: luowen
 * Date: 2017/3/8
 * Time: 22:05
 */

namespace App\Http\Controllers\Backend;


use App\Service\Pc\ActivityService;
use App\Service\Pc\IndustryService;
use Illuminate\Http\Request;

class CommonActController extends BaseController
{
    protected $subViewPath = "activity/common";

    public function index(Request $request)
    {
        if($request -> ajax()) {

            $this -> validate($request, [
                'title' => 'required'
            ]);

            $attributes = $request -> all();
            $activitySrv = (new ActivityService());
            $activitySrv -> fill($attributes) -> save();

            return $this -> _sendJsonResponse("创建成功",['insertId' => $activitySrv -> getAttribute("id")]);
        }

        $industryRepo = (new IndustryService()) -> all() -> toArray();
        return $this -> _sendViewResponse("index", ['industries' => $industryRepo]);
    }

    public function modify(Request $request, $id)
    {
        return $this -> _sendJsonResponse("修改成功", null, ['id' => $id]);
    }

    public function recommend(Request $request, $id)
    {
        $activityRepo = (new ActivityService()) -> find($id);
        if($activityRepo) {
            $status = $activityRepo -> setAttribute('is_recommend', 1) -> save();
            return $this -> _sendJsonResponse("推荐成功", ['status' => $status]);
        }
        return $this -> _sendJsonResponse("活动不存在", null, false);

    }

    public function putdown(Request $request , $id)
    {
        $activityRepo = (new ActivityService()) -> find($id);
        if($activityRepo) {
            $status = $activityRepo -> setAttribute('is_offshelf', 1) -> save();
            return $this -> _sendJsonResponse("下架成功", ['status' => $status]);
        }
        return $this -> _sendJsonResponse("活动不存在", null, false);
    }

}