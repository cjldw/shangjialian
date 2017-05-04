<?php
/**
 * Created by PhpStorm.
 * User: luowen
 * Date: 2017/3/5
 * Time: 22:01
 */

namespace App\Http\Controllers\Backend;


use App\Service\Pc\ActivityService;
use App\Service\Pc\MobileSkeletonService;
use Illuminate\Http\Request;

class MobileController extends BaseController
{
    protected $subViewPath = 'mobile';

    public function index(Request $request)
    {
        $mobileSkeletonRepo = (new MobileSkeletonService()) -> first();
        $bunnerUrl = $mobileSkeletonRepo ? $mobileSkeletonRepo -> getAttribute('banner_url') : '';
        $acts = (new ActivityService()) -> where('is_recommend', 1)
            -> limit(3) -> orderBy('created_at', 'desc') -> get();
        return $this -> _sendViewResponse('index', ['acts' => $acts, 'bannerUrl' => $bunnerUrl]);
    }

    public function changeBannerUrl(Request $request)
    {
        $mobileSkeletonRepo = (new MobileSkeletonService()) -> first();
        if(!$mobileSkeletonRepo) { return $this -> _sendJsonResponse('背景默认数据没有, 请联系管理员', null, false); }
        $this -> validate($request, [
            'banner_url' => 'required',
        ], [
            'banner_url.required' => '图片地址不能为空',
        ]);
        $bannerUrl = $request -> input('banner_url');
        $mobileSkeletonRepo -> setAttribute('banner_url', $bannerUrl);
        $stat = $mobileSkeletonRepo -> save();
        if(!$stat) { return $this -> _sendJsonResponse('保存失败', null, false); }
        return $this -> _sendJsonResponse('保存成功');

    }

}