<?php
/**
 * Created by PhpStorm.
 * User: luowen
 * Date: 2017/3/13
 * Time: 20:36
 */

namespace App\Http\Controllers\Api;


use App\Service\Api\MobileSkeletonService;
use Illuminate\Http\Request;

class MobileController extends BaseController
{
    /**
     * get banner url
     *
     * @return $this|\Illuminate\Http\JsonResponse
     */
    public function bannerUrl()
    {
        $resultSet = (new MobileSkeletonService()) -> first();
        if($resultSet) {
            return $this -> _sendJsonResponse('请求成功', $resultSet);
        }
        return $this -> _sendJsonResponse('请求失败', ['banner_url' => ''], false);
    }

}