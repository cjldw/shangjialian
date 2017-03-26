<?php
/**
 * Created by PhpStorm.
 * User: luowen
 * Date: 2017/3/25
 * Time: 22:34
 */

namespace App\Model;


use Illuminate\Database\Eloquent\Model;

class VisitLog extends Model
{

    protected $table = "visit_log";

    protected $fillable = [
        'merchant_id',
        'openid',
        'act_id',
        'created_at',
        'updated_at',
        'deleted_at',

    ];

}