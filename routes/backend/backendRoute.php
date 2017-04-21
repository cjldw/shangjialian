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
            Route::get('/{id}', ['uses' => 'ActivityController@modify', 'as' => 'Modify'])
                -> where(['id' => '[0-9]+']);

            Route::put("/{id}", ['uses' => 'ActivityController@recommend', 'as' => "Recommend"])
                -> where(['id' => '[0-9]+']);
            Route::delete('/{id}', ['uses' => 'ActivityController@offshelf', 'as' => 'Offshelf'])
                -> where(['id' => '[0-9]+']);

            Route::group(['prefix' => 'common', 'as' => 'Common::'], function () {
                Route::match(['get', 'post'], '/', ['uses' => 'CommonActController@index', 'as' => 'Index']);
                Route::put("/{id}", ['uses' => 'CommonActController@modifySync', 'as' => "ModifySync"])
                    -> where(['id' => '[0-9]+']);
                /*
                Route::delete('/{id}', ['uses' => 'CommonActController@putdown', 'as' => 'Putdown'])
                    -> where(['id' => '[0-9]+']);
                */
            });


            Route::group(['prefix' => 'bargain', 'as' => 'Bargain'], function () {
                Route::get('/', ['uses' => 'BargainActController@index', 'as' => 'index']);
            });


            Route::group(['prefix' => '/industry', 'as' => 'Industry::'], function (){
                Route::get('/', ['uses' => 'IndustryController@index', 'as' => 'Index']);
                Route::match(['get', 'post'], '/entity', ['uses' => 'IndustryController@create', 'as' => 'New']);
                Route::match(['get', 'put'], '/entity/{id}', ['uses' => 'IndustryController@update', 'as' => 'Update']);
                Route::delete('/entity/{id}', ['uses' => 'IndustryController@delete', 'as' => 'delete']);
            });
        });

        Route::group(['prefix' => '/merchant', 'as' => 'Merchant::'], function () {
            Route::get('/', ['uses' => 'MerchantController@index', 'as' => 'Index']);
            Route::put('/{id}', ['uses' => 'MerchantController@charge', 'as' => 'Charge'])
                -> where(['id' => '[0-9]+']);
            Route::put('/passwd/{id}', ['uses' => 'MerchantController@resetpwd', 'as' => 'Resetpwd'])
                -> where(['id' => '[0-9]+']);
        });

        Route::group(['prefix' => 'mobile', 'as' => 'Mobile::'], function() {
            Route::get('/', ['uses' => 'MobileController@index', 'as' => 'Index']);
        });

    });

});

