<?php
/**
 * Created by PhpStorm.
 * User: luowen
 * Date: 2017/3/12
 * Time: 21:46
 */

namespace App\Http\Controllers\Api;


use App\Service\Api\IndustryService;
use Illuminate\Http\Request;

class IndustryController extends BaseController
{

    public function index(Request $request)
    {
        $industryRepo = (new IndustryService()) -> orderBy("created_at", "desc") -> get();

        return $this -> _sendJsonResponse('请求成功', $industryRepo);
    }

}