<?php
/**
 * Created by PhpStorm.
 * User: luowen
 * Date: 2017/3/24
 * Time: 22:28
 */

namespace App\Model;


use Illuminate\Database\Eloquent\Model;

class MerchantActs extends Model
{

    protected $fillable = [
        'tpl_id',
        'merchant_id',
        'openid',
        'title',
        'industry_id',
        'description',
        'cover_img',
        'banner_img',
        'color_plate',
        'background_music',
        'act_start_time',
        'act_end_time',
        'act_prize_name',
        'act_prize_cnt',
        'act_prize_decorate',
        'act_prize_unit',
        'act_prize_desc',
        'act_rule_decorate',
        'act_rule_cnt',
        'act_rule_keywords',
        'act_rule_desc',
        'act_images',
        'organizer_name',
        'organizer_address',
        'organizer_phone',
        'about_us',
        'video_url',
        'link_name',
        'link_url',
        'act_type',
        'is_recommend',
        'created_at',
        'updated_at',
        'deleted_a',
    ];

    protected $table = "merchant_acts";

    public function setActImagesAttribute($value)
    {
        return $this -> attributes['act_images'] = json_encode($value, JSON_UNESCAPED_UNICODE);
    }

    public function getActImagesAttribute($value)
    {
        return json_decode($value, true);
    }

}