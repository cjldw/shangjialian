<?php
/**
 * Created by PhpStorm.
 * User: luowen
 * Date: 2017/3/9
 * Time: 23:12
 */

namespace App\Utils;


final class RandomUtils
{
    public static function randomChar($length = 4)
    {
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $string .= chr(rand(33, 126));
        }
        return $string;
    }

    public static function randString($length = 16)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

}