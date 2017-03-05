<?php
/**
 * Created by PhpStorm.
 * User: luowen
 * Date: 2017/3/5
 * Time: 21:55
 */

namespace App\Http\Controllers\Backend;


use Illuminate\Http\Request;

class MerchantController extends BaseController
{

    protected $subViewPath = 'merchant';

    public function index(Request $request)
    {
        return $this -> _sendViewResponse('index');
    }


}