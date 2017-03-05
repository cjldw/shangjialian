<?php
/**
 * Created by PhpStorm.
 * User: luowen
 * Date: 2017/3/4
 * Time: 14:11
 */

namespace App\Utils;

use Illuminate\Http\JsonResponse;
use Request;

trait JsonResponseTrait
{

    public function _sendJsonResponse($msg = "", $data = [], $success = true, $statusCode = 200, $callback = null)
    {
        // not a array ? serialize it.
        if(!is_array($data)) {
            if(is_object($data) && method_exists($data, 'toArray'))
                $data = $data -> toArray();
            else
                $data = [$data];
        }
        $data = $this -> fieldFilter($data);
        // fetch customer status code message
        if($msg == "") {
            $msgText = ($contentText = config('statuscode.' . $statusCode)) ? $contentText : "success" ;
            $msg = $msgText . ':[' . $statusCode . ']';
        }
        $response = new JsonResponse([], $statusCode, [], JSON_UNESCAPED_UNICODE);
        if($success)
        {
            $schema = [
                'code' => 0,
                'msg' => $msg,
                'data' => $data
            ];
            $response -> setData($schema);
        }
        else
        {
            $schema = [
                'code' => 1,
                'msg' => $msg,
                'data' => $data
            ];
            $response -> setData($schema);
        }
        return is_null($callback) ? $response : $response -> setCallback($callback);

    }
    protected function fieldFilter($data = [])
    {
        $filterData = [];
        $fields = Request::input("fields");

        if($fields && is_array($filedsArr = explode(',', $fields)))
        {
            foreach($filedsArr as $field)
            {
                $trimField = trim($field);
                $filterData[str_replace('.', '_', $trimField)] = Arr::get($data, $trimField, '');
            }
        }
        return empty($filterData) ? $data: $filterData;
    }



}