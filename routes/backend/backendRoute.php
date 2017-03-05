<?php
/**
 * Created by PhpStorm.
 * User: luowen
 * Date: 2017/3/4
 * Time: 13:48
 */

Route::group(['prefix' => 'admin', 'namespace' => '\Backend', 'as' => 'Backend::'], function (){

    Route::match(['get', 'post'], '/login', ['uses' => 'UserController@login', 'as' => 'login']);

    Route::group(['middleware' => 'auth:be'], function () {
        Route::get('/logout', ['uses' => 'UserController@logout', 'as' => 'logout']);
        Route::get('/', ['uses' => 'IndexController@index', 'as' => 'Index']);

        Route::group(['prefix' => 'activity', 'as' => 'Act::'], function() {

            Route::get('/', ['uses' => 'ActivityController@index', 'as' => 'Index']);
            Route::match(['get', 'post'], '/entity', ['uses' => 'ActivityController@create', 'as' => 'create']);
            Route::get('/common', ['uses' => 'ActivityController@common', 'as' => 'Common']);

            Route::get('/bargain', ['uses' => 'ActivityController@bargain', 'as' => 'Bargain']);

            Route::group(['prefix' => '/industry', 'as' => 'Industry::'], function (){
                Route::get('/', ['uses' => 'IndustryController@index', 'as' => 'Index']);
                Route::match(['get', 'post'], '/entity', ['uses' => 'IndustryController@create', 'as' => 'New']);
                Route::match(['get', 'put'], '/entity/{id}', ['uses' => 'IndustryController@update', 'as' => 'Update']);
                Route::delete('/entity/{id}', ['uses' => 'IndustryController@delete', 'as' => 'delete']);
            });
        });

        Route::group(['prefix' => '/merchant', 'as' => 'Merchant::'], function () {
            Route::get('/', ['uses' => 'MerchantController@index', 'as' => 'Index']);
        });

        Route::group(['prefix' => 'mobile', 'as' => 'Mobile::'], function() {
            Route::get('/', ['uses' => 'MobileController@index', 'as' => 'Index']);
        });

    });

});

