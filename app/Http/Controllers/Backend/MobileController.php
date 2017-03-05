<?php
/**
 * Created by PhpStorm.
 * User: luowen
 * Date: 2017/3/5
 * Time: 22:01
 */

namespace App\Http\Controllers\Backend;


use Illuminate\Http\Request;

class MobileController extends BaseController
{
    protected $subViewPath = "mobile";

    public function index(Request $request)
    {
        return $this -> _sendViewResponse('index');
    }

}