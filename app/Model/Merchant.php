<?php

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Merchant extends Authenticatable
{
    use Notifiable;

    protected $table = "merchant";

    protected $appends = [
        'expired_days',
    ];

    protected $fillable = [
        'name',
        'phone',
        'password',
        'salt',
    ];

    protected $hidden = [
        'salt',
        'password'
    ];

    public function getExpiredDays()
    {
        $now = Carbon::now();
        $expiredAt = Carbon::createFromFormat('Y-m-d H:i:s', $this -> expired_at);

        $diff = $expiredAt -> getTimestamp()  - $now -> getTimestamp();
        return $diff < 0 ? 0 : $diff / (3600 * 24);
    }

    public function getExpiredDaysAttribute()
    {
        $now = new \DateTime();
        $expiredAt = new \DateTime($this -> expired_at);

        if($expiredAt -> getTimestamp() - $now -> getTimestamp() < 0) {
            return "已经过期";
        }

        $time = "";
        $diff = $expiredAt -> diff($now);

        if(($year = $diff -> y) != 0) {
            $time = $year . '年';
        }

        if(($month = $diff -> m) != 0) {
            $time .= $month . "月";
        }

        if(($days = $diff -> days) != 0 ) {
            $time .= $days . '日';
        }

        if(($hour = $diff -> h) != 0) {
            $time .= $hour . '时';
        }

        if(($min = $diff -> i) != 0) {
            $time .= $min . '分';
        }
        return $time;
    }
}
