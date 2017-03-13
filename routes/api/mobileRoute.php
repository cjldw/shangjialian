<?php
/**
 * Created by IntelliJ IDEA.
 * User: luowen
 * Date: 2017/3/12
 * Time: 21:39
 */

Route::group(['namespace' => 'Api', 'middleware' => ['cors'], 'as' => 'API::'], function () {

    Route::group(['prefix' => 'skeleton', 'as' => 'Skeleton::'], function () {
        Route::get("/", ['uses' => 'IndexController@index', 'as' => 'index']);
    });

    Route::group(['prefix' => 'industry', 'as' => 'Industry::'], function () {
       Route::get("/", ['uses' => 'IndustryController@index', 'as' => "Index"]);
    });

    Route::group(['prefix' => 'user', 'as' => 'User::'], function () {
       Route::get("/", ['uses' => "UserController@index", 'as' => "Index"]) ;

       Route::post("/", ['uses' => "UserController@login", 'as' => "Login"]);
    });

    Route::group(['prefix' => 'act', 'as' => 'Act::'], function () {
       Route::get("/recommd", ['uses' => 'ActivityController@recommend', 'as' => 'Recommend']);
       Route::get("/industry/{id}", ['uses' => 'ActivityController@category', 'as' => 'Category']);
    });
});

