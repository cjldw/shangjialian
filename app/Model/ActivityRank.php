<?php
/**
 * Created by PhpStorm.
 * User: luowen
 * Date: 2017/3/23
 * Time: 22:01
 */

namespace App\Model;


use Illuminate\Database\Eloquent\Model;

class ActivityRank extends Model
{
    protected $table = "activity_rank";

    protected $fillable = [
        'act_id',
        'merchant_id',
        'openid',
        'name',
        'phone',
        'spend_time',
        'join_cnt',
        'completed_cnt',
        'level',
        'helpers',
        'is_completed',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

}