<?php
/**
 * Created by PhpStorm.
 * User: luowen
 * Date: 2017/3/6
 * Time: 18:32
 */

namespace App\Service;


class BaseService
{
    protected $modelClassMap = "";

    protected $instance = null;


    public function __call($name, $arguments)
    {
        if($this -> modelClassMap == "" && $this -> modelClassMap == null)
            throw new \Exception("properties of modelClassMap can not empty or null");
        $this -> instance = $this -> instance ? : (new $this -> modelClassMap);
        return call_user_func_array([$this -> instance, $name], $arguments);
    }
}