<?php
/**
 * Created by PhpStorm.
 * User: luowen
 * Date: 2017/3/9
 * Time: 21:47
 */

namespace App\Service\Api;


use App\Service\BaseService;
use App\Utils\RandomUtils;
use Carbon\Carbon;

class MerchantService extends BaseService
{
    protected $modelClassMap = \App\Model\Merchant::class;

    public function getUserInfo($openid)
    {
        $merchantRepo = (new static()) -> where(['openid' => $openid]) -> first();
        if($merchantRepo) {
            $merchantRepo -> setAttribute("login_cnt", $merchantRepo -> getAttribute("login_cnt") + 1);
            $merchantRepo -> setAttribute("updated_at", Carbon::now());
            $merchantRepo -> save();

            $days = $merchantRepo -> getExpiredDays();
            $isAvailable =  $days > 0 ? true : false;

            return [
                'openid' => $openid,
                'name' => $merchantRepo -> getAttribute("name"),
                'mobile' => $merchantRepo -> getAttribute("phone"),
                'isAvailable' => $isAvailable,
                'expireDays' => $days
            ];
        }

        $merchantRepo = new static();
        $merchantRepo -> setAttribute("openid", $openid);
        $merchantRepo -> setAttribute("salt", RandomUtils::randomChar(6));
        $merchantRepo -> save();
        return [
            'openid' => $openid,
            'name' => $merchantRepo -> getAttribute("name"),
            'mobile' => $merchantRepo -> getAttribute("phone"),
            'isAvailable' => false,
            'expireDays' => 0,
        ];
    }

}