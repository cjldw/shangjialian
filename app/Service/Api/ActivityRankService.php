<?php
/**
 * Created by PhpStorm.
 * User: luowen
 * Date: 2017/3/23
 * Time: 22:01
 */

namespace App\Service\Api;


use App\Service\BaseService;

class ActivityRankService extends BaseService
{
    protected $modelClassMap = \App\Model\ActivityRank::class;

    /**
     * get join count
     *
     * @param int $actId
     * @return mixed
     */
    public function getJoinCount($actId = 0)
    {
        return $this -> where([
            'act_id' => $actId
        ]) -> count();
    }

    /**
     * get completed count
     *
     * @param int $actId
     * @return mixed
     */
    public function getIsCompletedCount($actId = 0)
    {
        return $this -> where([
            'act_id' => $actId,
            'is_completed' => 1,
        ]) -> count();
    }


}