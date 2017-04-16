<?php
/**
 * Created by PhpStorm.
 * User: luowen
 * Date: 2017/3/4
 * Time: 14:21
 */

namespace App\Http\Controllers\Backend;


use App\Service\Pc\ActivityService;
use App\Service\Pc\IndustryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ActivityController extends BaseController
{

    protected $subViewPath = "activity/";

    public function index(Request $request)
    {
        $pageSize = $request -> input("pageSize");
        $titleLike = $request -> input("title");
        $builder = (new ActivityService()) -> with("industry") -> orderBy("created_at", "desc");
        if($titleLike != "") { // append title like condition
            $builder = $builder -> where("title", "like", '%'.$titleLike.'%');
        }
        $resultSet = $builder -> paginate($pageSize) -> toArray();
        $pageHtml = $this -> getPagination($resultSet, $request -> getPathInfo(), ['title' => $titleLike]);

        return $this -> _sendViewResponse("index", array_merge($resultSet,
            ['title' => $titleLike, 'pageHtml' => $pageHtml]
        ));
    }

    public function industry(Request $request)
    {
        return $this -> _sendViewResponse('industry');
    }

    public function common(Request $request)
    {
        if($request -> ajax()) {
            $attributes = $request -> all();
            $activitySrv = (new ActivityService());
            if(isset($attributes['act_start_time']) && $attributes['act_start_time'] == '') {
                $attributes['act_start_time'] = date("Y-m-d");
            }

            if(isset($attributes['act_end_time']) && $attributes['act_end_time'] == '') {
                $attributes['act_end_time'] = date("Y-m-d");
            }
            $activitySrv -> fill($attributes) -> save();
            return $this -> _sendJsonResponse("创建成功",['insertId' => $activitySrv -> getAttribute("id")]);
        }

        $industryRepo = (new IndustryService()) -> all() -> toArray();
        return $this -> _sendViewResponse("common", ['industries' => $industryRepo]);
    }


    public function bargain(Request $request)
    {
        return $this -> _sendViewResponse('bargain');
    }

    /**
     * modify activity bridge.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function modify(Request $request, $id)
    {
        $activityRepo = (new ActivityService()) -> find($id);
        if($activityRepo) {
            $actType = $activityRepo -> getAttribute("type");
            switch ($actType) {
                case 1:
                    return (new CommonActController($request)) -> modify($request, $id); //'Backend\CommonActController@modify', ['id' => $id]);
                    break;
                case 2:
                    return redirect() -> action('Backend\BargainActController@index', ['id' => $id]);
                    break;

                case 3:
                    return redirect() -> action('CommonActController@index', ['id' => $id]);
                    break;

                default:
                    return (new CommonActController($request)) -> modify($request, $id); //'Backend\CommonActController@modify', ['id' => $id]);
                    //return redirect() -> action('Backend\CommonActController@index', ['id' => $id]);
                    break;
            }
        }
        throw new NotFoundHttpException("活动不存在");
    }

    public function recommend(Request $request, $id)
    {
        $activityRepo = (new ActivityService()) -> find($id);
        if($activityRepo) {
            $isRecommend = abs(intval($activityRepo -> getAttribute("is_recommend")) - 1);
            $status = $activityRepo -> setAttribute("is_recommend", $isRecommend) -> save();
            return $this -> _sendJsonResponse('推荐成功', ['status' => $status]);
        }
        return $this -> _sendJsonResponse('活动不存在', null, false);
    }

    public function offshelf(Request $request, $id)
    {
        $activityRepo = (new ActivityService()) -> find($id);
        if($activityRepo) {
            $isOffshelf = abs(intval($activityRepo -> getAttribute("is_offshelf")) - 1);
            $status = $activityRepo -> setAttribute("is_offshelf", $isOffshelf) -> save();
            return $this -> _sendJsonResponse('下架成功', ['status' => $status]);
        }
        return $this -> _sendJsonResponse('活动不存在', null, false);
    }
}