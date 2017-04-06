<?php
/**
 * Created by PhpStorm.
 * User: luowen
 * Date: 2017/3/13
 * Time: 22:52
 */

namespace App\Utils;


final class HttpUtil
{
    use SingletonTrait;

    public static function post($url, $data = [])
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_NOBODY, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, false);
        $contents = curl_exec($curl);
        curl_close($curl);
        return $contents;

    }

    public static function get($url, $data = [])
    {
        if(strpos($url, '?') !== false) {
            $url .= "&" . http_build_query($data);
        } else {
            $url .= "?" . http_build_query($data);
        }
        $url = trim($url, '&');
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_NOBODY, false);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Expect:'));
        curl_setopt($curl, CURLOPT_TIMEOUT, 60);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        $contents = curl_exec($curl);
        curl_close($curl);
        return $contents;
    }


    public static function getInstance() {}
}