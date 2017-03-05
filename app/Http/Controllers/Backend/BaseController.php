<?php
/**
 * Created by PhpStorm.
 * User: luowen
 * Date: 2017/3/4
 * Time: 13:46
 */

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    protected $viewPath = "backend/";

    public function _sendViewResponse($viewName, $data = [])
    {
        /* covert data to array types */
        if(!is_array($data)) {
            if(is_object($data) && method_exists($data, 'toArray'))
                $data = $data -> toArray();
            else
                $data = [$data];
        }
        /* merge backend global configs */
        $data = array_merge($data,[
            'be' => [
                'endpoint' => '/admin'
            ]
        ]);
        return parent::_sendViewResponse($viewName, $data);
    }
}