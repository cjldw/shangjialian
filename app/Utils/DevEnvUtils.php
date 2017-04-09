<?php
/**
 * Created by PhpStorm.
 * User: luowen
 * Date: 2017/4/9
 * Time: 9:48
 */

namespace App\Utils;


final class DevEnvUtils
{

    public static function isDevelopEnv()
    {
        $env = config("app.env");
        return ($env == 'dev') ? : false;
    }

    public static function isProductionEnv()
    {
        $env = config("app.env");
        return ($env == 'production') ? : false;
    }

    public static function isTestingEnv()
    {
        $env = config("app.env");
        return ($env == 'testing') ? : false;
    }

}