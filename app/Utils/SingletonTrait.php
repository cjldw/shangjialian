<?php
/**
 * Created by PhpStorm.
 * User: luowen
 * Date: 2017/3/4
 * Time: 14:04
 */

namespace App\Http\Controllers\Utils;


Trait SingletonTrait
{

    private function __construct() { }

    private function __clone() { }


    abstract public static function getInstance();

}
