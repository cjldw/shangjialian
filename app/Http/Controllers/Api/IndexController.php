<?php
/**
 * Created by PhpStorm.
 * User: luowen
 * Date: 2017/3/12
 * Time: 21:47
 */

namespace App\Http\Controllers\Api;


use App\Service\Api\MobileSkeletonService;
use Illuminate\Http\Request;

class IndexController extends BaseController
{

    public function index(Request $request)
    {
        $mobileSkeletonRepo = new MobileSkeletonService();
        $resultSet = $mobileSkeletonRepo -> orderBy("created_at", "desc") -> first();
        return $this -> _sendJsonResponse('请求成功', $resultSet);
    }

}