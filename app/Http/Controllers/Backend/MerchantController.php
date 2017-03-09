<?php
/**
 * Created by PhpStorm.
 * User: luowen
 * Date: 2017/3/5
 * Time: 21:55
 */

namespace App\Http\Controllers\Backend;


use App\Service\Pc\MerchantService;
use App\Utils\RandomUtils;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MerchantController extends BaseController
{

    protected $subViewPath = 'merchant/';

    public function index(Request $request)
    {
        $pageSize = $request -> input('pageSize');
        $like = $request -> input('like');
        $builder = (new MerchantService()) -> orderBy('created_at', 'desc');

        if($like != '') {
            $builder = $builder -> where('name', 'like', '%'.$like.'%') -> orWhere('phone', 'like', '%'.$like.'%');
        }
        $resultSet = $builder -> paginate($pageSize) -> toArray();
        $pageHtml = $this -> getPagination($resultSet, $request -> getPathInfo(), ['like' => $like]);

        return $this -> _sendViewResponse('index', array_merge($resultSet, [
            'like' => $like,
            'pageHtml' => $pageHtml
        ]));
    }

    public function charge(Request $request, $id)
    {
        $merchantRepo = (new MerchantService()) -> find($id);
        if($merchantRepo) {
            $days = intval($request -> input("days"));
            if($days > 0) {
                $dateInterval = new \DateInterval("P".$days."D");
                $newExpiredAt = (new \DateTime($merchantRepo -> getAttribute("expired_at"))) -> add($dateInterval);
                $merchantRepo -> setAttribute("expired_at", $newExpiredAt) -> save();

                return $this -> _sendJsonResponse("充值成功", ['days' => $days]);
           }
           return $this ->  _sendJsonResponse('天数必须是数子', null, false);
        }
        throw new NotFoundHttpException("用户不存在");
    }

    public function resetpwd(Request $request, $id)
    {
        $merchantRepo = (new MerchantService()) -> find($id);

        if($merchantRepo) {
            $defaultpwd = config("constant.resetpasswd", '111111');
            $newpasswd = md5($merchantRepo -> getAttribute("salt") . $defaultpwd);
            $merchantRepo -> setAttribute("password", $newpasswd) -> save();
            return $this -> _sendJsonResponse('重置成功', ['resetpasswd' => $defaultpwd]);
        }
        throw new  NotFoundHttpException("用户不存在");
    }

}