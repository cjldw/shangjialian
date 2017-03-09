<?php
/**
 * Created by PhpStorm.
 * User: luowen
 * Date: 2017/3/5
 * Time: 22:01
 */

namespace App\Http\Controllers\Backend;


use App\Service\Pc\ActivityService;
use Illuminate\Http\Request;

class MobileController extends BaseController
{
    protected $subViewPath = "mobile";

    public function index(Request $request)
    {
        $acts = (new ActivityService()) -> where("is_recommend", 1)
            -> limit(3) -> orderBy("created_at", "desc") -> get();
        return $this -> _sendViewResponse('index', ['acts' => $acts]);
    }

}