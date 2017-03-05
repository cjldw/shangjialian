<?php
/**
 * Created by PhpStorm.
 * User: luowen
 * Date: 2017/3/5
 * Time: 21:29
 */

namespace App\Http\Controllers\Backend;


use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class IndustryController extends BaseController
{

    protected $subViewPath = "industry";

    public function index(Request $request)
    {
        return $this -> _sendViewResponse("index");
    }

    public function create(Request $request)
    {
        if($request -> ajax())
        {
            return $this -> _sendJsonResponse("ok");
        }

        return $this -> _sendViewResponse("new");
    }


    public function update(Request $request, $id)
    {
        if($request -> ajax())
        {
            return $this -> _sendJsonResponse("ok");
        }
        return $this -> _sendViewResponse("update");
    }

    public function delete(Request $request, $id)
    {
        return $this -> _sendJsonResponse("ok");
    }
}