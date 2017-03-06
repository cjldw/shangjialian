<?php

namespace App\Http\Controllers;

use App\Utils\JsonResponseTrait;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    protected $viewPath = "";

    protected $subViewPath = "";

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    use JsonResponseTrait;

    public function __construct(Request $request)
    {
         /* add default pagesize to request instance */
        if(!$request -> input("pageSize")) {
            $request -> request -> add(['pageSize' => config("constants.pageSize", 15)]);
        }
    }

    protected function _sendViewResponse($viewName, $data = [])
    {
        $absoluteViewPath = trim($this -> viewPath, '/') . "/" . trim($this -> subViewPath, '/') . '/' . ltrim($viewName);
        return view($absoluteViewPath, $data);
    }
}
