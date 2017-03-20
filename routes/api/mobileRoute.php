<?php
/**
 * Created by IntelliJ IDEA.
 * User: luowen
 * Date: 2017/3/12
 * Time: 21:39
 */

Route::group(['namespace' => 'Api', 'middleware' => ['cors'], 'as' => 'API::'], function () {

    Route::group(['prefix' => '/mobile', 'as' => 'Mobile::'], function () {
        Route::get("/banner", ['uses' => 'MobileController@bannerUrl', 'as' => 'Banner']);
    });

    Route::group(['prefix' => 'industry', 'as' => 'Industry::'], function () {
       Route::get("/", ['uses' => 'IndustryController@index', 'as' => "Index"]);
    });

    Route::group(['prefix' => 'user', 'as' => 'User::'], function () {
       Route::get("/", ['uses' => "UserController@index", 'as' => "Index"]) ;

       Route::post("/login", ['uses' => "UserController@login", 'as' => "Login"]);

       Route::post("/register", ['uses' => 'UserController@register', 'as' => 'Register']);
       Route::post("/captcha", ['uses' => 'UserController@captcha', 'as' => 'Captcha']);
    });

    Route::group(['prefix' => 'act', 'as' => 'Act::'], function () {
        Route::get("/{id}", ['uses' => 'ActivityController@detail', 'as' => 'Detail'])
            -> where(['id' => '[0-9]+']);
        Route::get("/recommd", ['uses' => 'ActivityController@recommend', 'as' => 'Recommend']);
        Route::get("/industry/{id}", ['uses' => 'ActivityController@industry', 'as' => 'Category']);
    });

    Route::group(['prefix' => 'mine', 'as' => 'Mine::'], function () {

    });
});

