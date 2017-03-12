<?php
/**
 * Created by PhpStorm.
 * User: luowen
 * Date: 2017/3/4
 * Time: 15:07
 */

Route::group(['as' => "Front", "namespace" => "Frontend", 'as' => 'Frontend::'], function () {
    //Route::get("/", ['uses' => "IndexController@index", "as" => "Index"]);
    Route::get("/", function () {
        return redirect("/admin");
    });

});
