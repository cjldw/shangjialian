<?php
/**
 * Created by PhpStorm.
 * User: luowen
 * Date: 2017/3/8
 * Time: 22:05
 */

namespace App\Http\Controllers\Backend;


use Illuminate\Http\Request;

class BargainActController extends BaseController
{
    protected $subViewPath = "activity/bargain/";

    public function index(Request $request)
    {
        return $this -> _sendViewResponse("index");
    }

}