<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class MobileSkeleton extends Model
{
    protected $table = "mobile_skeleton";

    protected $fillable = [
        'banner_url',
    ];
}
