<?php
/**
 * Created by PhpStorm.
 * User: luowen
 * Date: 2017/3/12
 * Time: 21:45
 */

namespace App\Http\Controllers\Api;


use Illuminate\Http\Request;

class MineController extends BaseController
{

    public function top1(Request $request)
    {
        return $this -> _sendJsonResponse("请求成功");
    }

    public function start(Request $request)
    {
        return $this -> _sendJsonResponse("请求成功");
    }

    public function nostart(Request $request)
    {
        return $this -> _sendJsonResponse("请求成功");
    }

    public function end(Request $request)
    {
        return $this -> _sendJsonResponse("请求成功");
    }



}