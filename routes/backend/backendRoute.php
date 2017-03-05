<?php
/**
 * Created by PhpStorm.
 * User: luowen
 * Date: 2017/3/4
 * Time: 13:48
 */

Route::group(['prefix' => 'admin', 'namespace' => '\Backend', 'as' => 'Backend::'], function (){

    Route::match(["get", "post"], "/login", ['uses' => "UserController@login", 'as' => "login"]);

    Route::group(['middleware' => "auth:be"], function () {
        Route::get("/logout", ['uses' => "UserController@logout", 'as' => "logout"]);
        Route::get("/", ['uses' => 'IndexController@index', 'as' => 'Index']);
    });

});

