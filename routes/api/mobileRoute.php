<?php
/**
 * Created by IntelliJ IDEA.
 * User: luowen
 * Date: 2017/3/12
 * Time: 21:39
 */

Route::group(['namespace' => 'Api', 'middleware' => ['web', 'cors'], 'as' => 'API::'], function () {
    Route::group(['prefix' => '/wechat', 'as' => 'Wechat::'], function () {
        Route::get("/authorization", ['uses' => 'WxController@authorization', 'as' => 'Authorization']);
        Route::get("/userinfo", ['uses' => 'WxController@userinfo', 'as' => 'Userinfo']);
        Route::get("/jstoken", ['uses' => 'WxController@jsToken', 'as' => 'JsToken']);
    });

    Route::group(['middleware' => ['wx']], function () {
        Route::group(['prefix' => '/mobile', 'as' => 'Mobile::'], function () {
            Route::get("/banner", ['uses' => 'MobileController@bannerUrl', 'as' => 'Banner']);
        });

        Route::group(['prefix' => 'industry', 'as' => 'Industry::'], function () {
            Route::get("/", ['uses' => 'IndustryController@index', 'as' => "Index"]);
        });

        Route::group(['prefix' => 'user', 'as' => 'User::'], function () {
            Route::get("/", ['uses' => "UserController@index", 'as' => "Index"]) ;

            /* 获取用户登入信息 多次登入后, 可无需在登入*/
            Route::get("/logininfo", ['uses' => 'UserController@loginInfo', 'as' => 'LoginInfo']);

            Route::post("/login", ['uses' => "UserController@login", 'as' => "Login"]);

            Route::post("/logout", ['uses' => "UserController@logout" , 'as' => "Logout"]);

            Route::post("/bindmobile", ['uses' => 'UserController@bindmobile', 'as' => 'Bindmobile']);
            Route::post("/captcha", ['uses' => 'UserController@captcha', 'as' => 'Captcha']);

            Route::get("/pwd/captcha", ['uses' => 'UserController@getResetPwdCaptcha', 'ResetPwdCaptcha']);
            Route::post("/pwd/verifycode", ['uses' => 'UserController@verifyResetPwdCaptchaCode', 'as' => 'VerifyCode']);
            Route::post("/pwd/reset", ['uses' => 'UserController@resetpwd', 'as' => 'ResetPwd' ]);
        });

        Route::group(['prefix' => 'act', 'as' => 'Act::'], function () {
            Route::get("/{id}", ['uses' => 'ActivityController@detail', 'as' => 'Detail'])
                -> where(['id' => '[0-9]+']);
            Route::get("/recommd", ['uses' => 'ActivityController@recommend', 'as' => 'Recommend']);
            Route::get("/industry/{id}", ['uses' => 'ActivityController@industry', 'as' => 'Category']);
            Route::get("/rank", ['uses' => 'ActivityController@getDefaultRank', 'as' => 'Rank']);


            Route::group(['prefix' => 'shared', 'as' => 'Shared::'], function () { // 活动分享后相关

                /* 用户成就 */
                Route::get("/feats", ['uses' => 'SharedController@getUserInfo', 'as' => 'Feats']);

                /* 活动完成人数 */
                Route::get("/completed/{id}", ['uses' => 'SharedController@completedCnt', 'completedCnt'])
                    -> where(['id' => '[0-9]+']);

                Route::get("/{id}", ['uses' => 'SharedController@sharedAct', 'as' => 'SharedAct'])
                    -> where(['id' => '[0-9]+']);

                Route::get("/rank/{id}", ['uses' => 'SharedController@getActRank', 'as' => 'Rank'])
                    -> where(['id' => '[0-9]+']);


                Route::post("/helpit", ['uses' => 'SharedController@helpIt', 'as' => 'HelpIt']);

                /* 我也要玩 */
                Route::get("/isplay", ['uses' => 'SharedController@isPlay', 'as' => 'IsPlay']);
                Route::post("/play", ['uses' => 'SharedController@play', 'as' => 'Play']);

                /* 来访记录*/
                Route::post("/visitlog", ['uses' => 'SharedController@visitLog', 'as' => 'VisitLog']);
            });

            Route::group(['prefix' => "u", 'middleware' => ['rich'],  'as' => "User::"], function () { // 需要用户登入才能访问了
                Route::post("/", ['uses' => 'UserActController@createAct', 'as' => 'CreateAct']);
                Route::delete("/{id}", ['uses' => 'UserActController@deleteById','as' => 'Delete'])
                    -> where(['id' => '[0-9]+']);
                Route::put("/{id}", ['uses' => 'UserActController@updateById', 'as' => "Update"])
                    -> where(['id' => '[0-9]+']);

            });
        });

        Route::group(['prefix' => 'mine', 'as' => 'Mine::'], function () { // 需要用户登入
            Route::get("/top1", ['uses' => "MineController@top1", 'as' => 'Top1']);
            Route::get("/start", ['uses' => 'MineController@start', 'as' => 'Start']);
            Route::get("/nostart", ['uses' => 'MineController@nostart', 'as' => 'NoStart']);
            Route::get("/end", ['uses' => 'MineController@end', 'as' => 'End']);
        });

    });
});

