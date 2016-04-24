<?php

Route::group(['middleware' => ['withoutLogin']], function () {
    Route::get('test', 'TestController@index');
    Route::get('test/login', 'TestController@login');
    Route::get('test/logout', 'TestController@logout');
    Route::get('test/check', 'TestController@check');
});

Route::group(['middleware' => ['web']], function () {

////    Route::post('test', 'TestController@store');

    Route::group(['prefix' => \Illuminate\Support\Facades\Config::get('constants.route.admin')], function () {
        Route::get('/', function () {
            return view('admin.index');
        });

        /**
         * User System
         */
        Route::any('user/{id}/super', 'Admin\UserController@changeSuper');

        /**
         * Image System
         */
        Route::get('image', 'Admin\ImageController@index');
        Route::get('image/create', 'Admin\ImageController@create');
        Route::get('image/{id}', 'Admin\ImageController@show');
        Route::post('image/store', 'Admin\ImageController@store');
        Route::put('image/{id}', 'Admin\ImageController@update');
        Route::delete('image/{id}', 'Admin\ImageController@destroy');

        /**
         * Production System
         */
        //Series
        Route::get('series', 'Admin\SeriesController@index');
        Route::get('series/create', 'Admin\SeriesController@create');
        Route::post('series/store', 'Admin\SeriesController@store');
        Route::delete('series/{id}', 'Admin\SeriesController@destroy');

        //Production
        Route::get('production', 'Admin\ProductionController@index');
        Route::get('production/create', 'Admin\ProductionController@create');
        Route::get('production/{alias}', 'Admin\ProductionController@show');
        Route::get('production/{alias}/edit', 'Admin\ProductionController@edit');

        Route::post('production/store', 'Admin\ProductionController@store');
        Route::post('production/{id}/color/store', 'Admin\ProductionController@storeColor');
        Route::post('production/{id}/color/{cid}/image/store', 'Admin\ProductionController@storeImage');
        Route::post('production/{id}/color/{cid}/size/store', 'Admin\ProductionController@storeSize');
        Route::put('production/{id}', 'Admin\ProductionController@updateProduction');
        Route::put('production/{id}/color/{color_id}', 'Admin\ProductionController@updateProductionColor');
        Route::delete('production/{alias}', 'Admin\ProductionController@destroyProduction');
        Route::delete('color/{alias}', 'Admin\ProductionController@destroyColor');
        Route::delete('production/size/{id}', 'Admin\ProductionController@destroySize');
        Route::delete('production/image/{id}', 'Admin\ProductionController@destroyImage');

        //Order
        Route::get('order', 'Admin\OrderController@index');
        Route::get('order/{id}', 'Admin\OrderController@show');
        Route::post('order/{id}/deliver', 'Admin\OrderController@deliverOrder');
        Route::post('order/{orderNo}/rejected', 'Admin\OrderController@rejected');

        //Cash
        Route::get('cash', 'Admin\CashController@index');

        //Latest 最新商品
        Route::get('latest/edit', 'Admin\LatestController@index');
        Route::post('latest/store', 'Admin\LatestController@store');
        Route::any('latest/destroy', 'Admin\LatestController@destroyAll');


        //ajax
        Route::any('ajax/image', 'Admin\Ajax\ImageController@all');
        Route::any('ajax/production', 'Admin\Ajax\ProductionController@all');
    });

    //ajax
    Route::group(['prefix' => 'ajax'], function () {
        Route::post('get/quantity/{id}', 'ProductionController@getQuantityBySize');
    });

    //Common Controller

    //Index
    Route::get('/', 'IndexController@index');

    //User
    Route::get('/qrcode', 'UserController@getQrCode');
    Route::get('/qrcode/create', 'UserController@generateQrCode');

    //Production
    Route::get('production/{alias}', 'ProductionController@show');
    Route::get('buy/{alias}', 'ProductionController@redirect');
    Route::get('buy/{alias}/{colorAlias}', 'ProductionController@buy');

    //cart
    Route::get('cart/update', 'CartController@add');

    // Order
    Route::get('order/create', 'OrderController@create');
    Route::post('order/store', 'OrderController@store');
    Route::any('order/notify', 'OrderController@notify');
    Route::any('order/{orderNo}/reject', 'OrderController@reject');

    // Address
    Route::get('address/create', 'AddressController@create');
    Route::get('address/{id}/edit', 'AddressController@edit');

    Route::post('address/store', 'AddressController@store');
    Route::post('address/{id}', 'AddressController@update');

    // QrCode
    Route::get('qrcode', 'UserController@getQrCode');

    Route::get('user', 'UserController@userCenter');
});

Route::group([
    'prefix' => 'wechat',
    'middleware' => 'wechat',
], function(){
    Route::any('server', 'Wechat\ServerController@index');

    Route::any('login', 'Wechat\AuthController@index');

    Route::any('auth/callback', 'Wechat\AuthController@callback');
    Route::any('pay/{wechatOrderNo}', 'Wechat\PayController@pay');
    Route::any('refund/{wechatOrderNo}', 'Wechat\PayController@refund');
    Route::any('cash', 'Wechat\PayController@getCash');

    Route::any('qrcode/create', 'Wechat\QrcodeController@create');
});
