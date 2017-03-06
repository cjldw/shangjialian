<?php
/**
 * Created by PhpStorm.
 * User: luowen
 * Date: 2017/3/6
 * Time: 18:36
 */

namespace App\Model;


use Illuminate\Database\Eloquent\Model;

class Industry extends Model
{

    protected $table =  "industry";

    protected $fillable = [
        'name',
        'parent_id',
    ];

}