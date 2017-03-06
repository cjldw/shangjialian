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

    protected function getPagination($paginationData, $url = '/', $appendUrl = [])
    {
        $pagination = '';
        $lastPage = $paginationData['last_page'];
        if($lastPage > 1) {
            $appendUrl['pageSize'] = $paginationData['per_page'];

            $currentPage = $paginationData['current_page'];
            $url .= '?' . http_build_query($appendUrl);

            $pagination .= '<ul class="pagination pagination-sm">';
            $pagination .= '<li><a href="' . $url . '">首页</a></li>';

            if($currentPage >= 2) {
                $prePageUrl = $url . '&' . http_build_query(['page' => $currentPage - 1]);
                $pagination .= '<li><a href="' . $prePageUrl . '">上一页</a></li>';
            }
            if($currentPage < $lastPage && $currentPage > 0) {
                $nextPageUrl = $url . '&' . http_build_query(['page' => $currentPage + 1]);
                $pagination .= '<li><a href="' . $nextPageUrl . '">下一页</a></li>';
            }
            $lastPageUrl = $url . "&" . http_build_query(['page' => $lastPage]);
            $pagination .= '<li><a href="' . $lastPageUrl . '">末页</a></li></ul>';
        }
        return $pagination;
    }
}