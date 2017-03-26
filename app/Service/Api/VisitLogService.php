<?php
/**
 * Created by PhpStorm.
 * User: luowen
 * Date: 2017/3/25
 * Time: 22:35
 */

namespace App\Service\Api;


use App\Service\BaseService;

class VisitLogService extends BaseService
{
    protected $modelClassMap = \App\Model\VisitLog::class;

    public function getVisitCount($actId)
    {
        return $this -> where([
          'act_id' => $actId
        ]) -> count();
    }

}