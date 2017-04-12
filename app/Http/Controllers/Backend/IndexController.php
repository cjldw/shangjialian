<?php
/**
 * Created by PhpStorm.
 * User: luowen
 * Date: 2017/3/4
 * Time: 13:50
 */

namespace App\Http\Controllers\Backend;


use App\Service\Pc\ActivityRankService;
use App\Service\Pc\MerchantActsService;
use App\Service\Pc\MerchantService;
use App\Service\Pc\VisitLogService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class IndexController extends BaseController
{

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $startOfWeek = Carbon::now() -> startOfWeek();
        $now = Carbon::now();

        $visitLogRepo = new VisitLogService();
        $totalViewCnt = $visitLogRepo -> count();
        $totalViewDeltaCnt = $visitLogRepo -> where('created_at', '>=', $startOfWeek)
            -> where('created_at', '<=', $now) -> count();

        $activityRankRepo = (new ActivityRankService());
        $merchantCopyCnt = $activityRankRepo -> where([
            'level' => 0
        ]) -> count();
        $merchantCopyDeltaCnt = $activityRankRepo -> where("level", '=', 0)
            -> where("created_at", '>=', $startOfWeek)
            -> where('created_at', '<=', $now)
            -> count();

        $netPeopleCopyCnt = $activityRankRepo -> where([
            'level' => 1,
        ]) -> count();
        $netPeopleCopyDeltaCnt = $activityRankRepo -> where('level', '=', 1)
            -> where("created_at", '>=', $startOfWeek)
            -> where('created_at', '<=', $now)
            -> count();

        $merchantActsRepo = new MerchantActsService();
        $activityCnt = $merchantActsRepo -> count();
        $activityDeltaCnt = $merchantActsRepo -> where('created_at', '>=', $startOfWeek)
            -> where('created_at', '<=', $now)
            -> count();

        $merchantRepo = new MerchantService();
        $merchantCnt = $merchantRepo -> count();
        $merchantDeltaCnt = $merchantRepo  -> where('created_at', '>=', $startOfWeek)
            -> where('created_at', '<=', $now)
            -> count();

        $visitLogRepo = new VisitLogService();
        $totalUserCnt = $visitLogRepo -> count();
        $totalUserDeltaCnt = $visitLogRepo -> where('created_at', '>=', $startOfWeek)
            -> where('created_at', '<=', $now)
            -> count();

        return $this -> _sendViewResponse("index", [
            'total_visit_cnt' => $totalViewCnt,
            'total_visit_delta_cnt' => $totalViewDeltaCnt,

            'net_people_copy_cnt' => $netPeopleCopyCnt,
            'net_people_copy_delta_cnt' => $netPeopleCopyDeltaCnt,

            'activity_cnt' => $activityCnt,
            'activity_delta_cnt' => $activityDeltaCnt,

            'merchant_copy_cnt' => $merchantCopyCnt,
            'merchant_copy_delta_cnt' => $merchantCopyDeltaCnt,

            'merchant_cnt' => $merchantCnt,
            'merchant_delta_cnt' => $merchantDeltaCnt,

            'total_user_cnt' => $totalUserCnt,
            'total_user_delta_cnt' => $totalUserDeltaCnt,
        ]);
    }

}