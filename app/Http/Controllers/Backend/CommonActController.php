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
                'title' => 'required',
                'industry_id' => 'required',
                'cover_img' => 'required',
                'banner_img' => 'required',
                'description' => 'required',
                'act_rule_cnt' => 'required',
                'act_rule_decorate' => 'required',
                'act_rule_keywords' => 'required',
                'act_rule_desc' => 'required',
                'act_prize_decorate' => 'required',
                'act_prize_cnt' => 'required',
                'act_prize_unit' => 'required',
                'act_prize_name' => 'required',
                'act_prize_desc' => 'required',
            ], [
                'title.required' => '活动标题不能为空',
                'industry_id.required' => '所属行业不能为空',
                'cover_img.required' => '封面图片不能为空',
                'banner_img.required' => '活动背景图片不能为空',
                'description.required' => '活动描述不能为空',
                'act_rule_cnt.required' => '请填写完整参与规则',
                'act_rule_decorate.required' => '请填写完整参与规则',
                'act_rule_keywords.required' => '请填写完整参与规则',
                'act_rule_desc.required' => '请填写规则描述',
                'act_prize_decorate.required' => '请填写完成奖品信息',
                'act_prize_cnt.required' => '请填写奖品数量',
                'act_prize_unit.required' => '请填写奖品单位',
                'act_prize_name.required' => '请填写奖品名称',
                'act_prize_desc.required' => '请填写奖品描述',
            ]);

            $attributes = $request -> all();
            $activitySrv = (new ActivityService());
            if(is_null($attributes['act_start_time'])) {
                $attributes['act_start_time'] = date("Y-m-d");
            }
            if(is_null($attributes['act_end_time'])) {
                $attributes['act_end_time'] = date("Y-m-d", strtotime("+1 month"));
            }
            $activitySrv -> fill($attributes) -> save();
            return $this -> _sendJsonResponse("创建成功",['insertId' => $activitySrv -> getAttribute("id")]);
        }

        $industryRepo = (new IndustryService()) -> all() -> toArray();
        return $this -> _sendViewResponse("index", ['industries' => $industryRepo]);
    }

    /**
     * 编辑页面
     *
     * @param Request $request
     * @param $id
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function modify(Request $request, $id)
    {
        $activityRepo = (new ActivityService()) -> find($id);
        if(!$activityRepo) {
            return $this -> _sendJsonResponse('活动不存在', null, false);
        }
        $industryRepo = (new IndustryService()) -> all() -> toArray();

        return $this -> _sendViewResponse('modify', ['actRepo' => $activityRepo, 'industries' => $industryRepo]);
    }

    /**
     * asynchronized activity
     *
     * @param Request $request
     * @param $id
     * @return $this|\Illuminate\Http\JsonResponse
     */
    public function modifySync(Request $request, $id)
    {
        $activityRepo = (new ActivityService()) -> find($id);

        if(!$activityRepo) {
            return $this -> _sendJsonResponse('活动不存在', null, false);
        }

        $this -> validate($request, [
            'title' => 'required',
            'industry_id' => 'required',
            'cover_img' => 'required',
            'banner_img' => 'required',
            'description' => 'required',
            'act_rule_cnt' => 'required',
            'act_rule_decorate' => 'required',
            'act_rule_keywords' => 'required',
            'act_rule_desc' => 'required',
            'act_prize_decorate' => 'required',
            'act_prize_cnt' => 'required',
            'act_prize_unit' => 'required',
            'act_prize_name' => 'required',
            'act_prize_desc' => 'required',
        ], [
            'title.required' => '活动标题不能为空',
            'industry_id.required' => '所属行业不能为空',
            'cover_img.required' => '封面图片不能为空',
            'banner_img.required' => '活动背景图片不能为空',
            'description.required' => '活动描述不能为空',
            'act_rule_cnt.required' => '请填写完整参与规则',
            'act_rule_decorate.required' => '请填写完整参与规则',
            'act_rule_keywords.required' => '请填写完整参与规则',
            'act_rule_desc.required' => '请填写规则描述',
            'act_prize_decorate.required' => '请填写完成奖品信息',
            'act_prize_cnt.required' => '请填写奖品数量',
            'act_prize_unit.required' => '请填写奖品单位',
            'act_prize_name.required' => '请填写奖品名称',
            'act_prize_desc.required' => '请填写奖品描述',
        ]);

        $attributes =  $request -> all();
        if(is_null($attributes['act_start_time'])) {
            $attributes['act_start_time'] = date("Y-m-d");
        }
        if(is_null($attributes['act_end_time'])) {
            $attributes['act_end_time'] = date("Y-m-d", strtotime("+1 month"));
        }
        $activityRepo -> fill($attributes) -> save();
        return $this -> _sendJsonResponse('修改成功', $activityRepo);
    }

    /**
     * recommend activity synchronized
     *
     * @param Request $request
     * @param $id
     * @return $this|\Illuminate\Http\JsonResponse
     */
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