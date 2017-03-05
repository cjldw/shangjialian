<?php
/**
 * Created by PhpStorm.
 * User: luowen
 * Date: 2017/3/4
 * Time: 13:50
 */

namespace App\Http\Controllers\Backend;


use Illuminate\Http\Request;

class IndexController extends BaseController
{

    public function index(Request $request)
    {
        return $this -> _sendViewResponse("index", []);
    }

}