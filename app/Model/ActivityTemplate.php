<?php
/**
 * Created by PhpStorm.
 * User: luowen
 * Date: 2017/3/6
 * Time: 18:36
 */

namespace App\Model;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActivityTemplate extends Model
{
    use SoftDeletes;

    protected $table = "activity_template";

    protected $fillable = [
        "title",
        "industry_id",
        "description",
        "cover_img",
        "banner_img",
        "color_plate",
        "background_music",
        "act_start_time",
        "act_end_time",
        "act_prize_name",
        "act_prize_cnt",
        "act_prize_decorate",
        "act_prize_unit",
        "act_prize_desc",
        "act_rule_desc",
        "act_rule_decorate",
        "act_rule_cnt",
        "act_rule_keywords",
        "act_images",
        "organizer_name",
        "organizer_address",
        "organizer_phone",
        "about_us",
        "video_url",
        "link_name",
        "link_url",
        "act_type",
        "is_recommend",
        "is_offshelf",
        "bizman_copy_cnt",
        "netizen_copy_cnt",
        "created_at",
        "updated_at",
        "deleted_at",
    ];

    public function industry()
    {
        return $this -> hasOne(\App\Model\Industry::class, "id", "industry_id");
    }
}