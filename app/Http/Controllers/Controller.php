<?php

namespace App\Http\Controllers;

use App\Utils\JsonResponseTrait;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    protected $viewPath = "";

    protected $subViewPath = "";

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    use JsonResponseTrait;

    protected function _sendViewResponse($viewName, $data = [])
    {
        $absoluteViewPath = trim($this -> viewPath, '/') . "/" . trim($this -> subViewPath, '/') . '/' . ltrim($viewName);
        return view($absoluteViewPath, $data);
    }
}
