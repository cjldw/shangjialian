<?php
/**
 * Created by PhpStorm.
 * User: luowen
 * Date: 2017/3/4
 * Time: 15:08
 */

namespace App\Http\Controllers\Frontend;


use Illuminate\Http\Request;

class IndexController extends BaseController
{
    public function index(Request $request)
    {

        return $this -> _sendViewResponse("index");
    }

}