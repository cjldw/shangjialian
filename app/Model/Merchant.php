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
        if(!$this -> expired_at)
            return 0;
        $now = Carbon::now();
        $expiredAt = Carbon::createFromFormat('Y-m-d H:i:s', $this -> expired_at);

        $diff = $expiredAt -> getTimestamp()  - $now -> getTimestamp();
        return $diff < 0 ? 0 : ceil($diff / (3600 * 24));
    }

    public function getExpiredDaysAttribute()
    {
        $now = Carbon::now();
        $expiredAt = Carbon::createFromFormat("Y-m-d", $this -> expired_at ? : date('Y-m-d'));

        if($expiredAt -> getTimestamp() <= $now -> getTimestamp()) {
            return "已经过期";
        }

        return ($expiredAt -> diffInDays($now) + 1) . '天';
    }
}
