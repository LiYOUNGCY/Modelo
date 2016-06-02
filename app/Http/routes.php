<?php

Route::group(['middleware' => ['withoutLogin']], function () {
    Route::get('test', 'TestController@index');
    Route::get('test/login', 'TestController@login');
    Route::get('test/logout', 'TestController@logout');
    Route::get('test/check', 'TestController@check');
    Route::get('test/pay', 'TestController@pay');

    Route::get('/deny', 'IndexController@deny');
});

Route::group(['middleware' => ['web']], function () {

    Route::group(['prefix' => \Illuminate\Support\Facades\Config::get('constants.route.admin')], function () {
        Route::get('/', function () {
            return view('admin.index');
        });

        /**
         * User System
         */
        Route::get('user/relation', 'Admin\UserController@relation');
        Route::get('user', 'Admin\UserController@index');
        Route::get('user/{id}', 'Admin\UserController@show');

        /**
         * Image System
         */
        Route::get('image', 'Admin\ImageController@index');
        Route::get('image/upload', 'Admin\ImageController@upload');
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
        Route::get('production/{productionId}/edit', 'Admin\ProductionController@edit');

        Route::post('production/store', 'Admin\ProductionController@store');
        Route::post('production/{productionId}/color/store', 'Admin\ProductionController@storeColor');
        Route::post('production/{productionId}/update', 'Admin\ProductionController@updateProduction');
        Route::post('color/{colorId}/update', 'Admin\ProductionController@updateColor');
        Route::post('color/{colorId}/destroy', 'Admin\ProductionController@destroyColor');
        Route::post('production/size/{sizeId}/destroy', 'Admin\ProductionController@destroySize');
        Route::post('production/image/{imageId}/destroy', 'Admin\ProductionController@destroyImage');
        Route::post('production/{Id}/destroy', 'Admin\ProductionController@destroyProduction');

        //Order
        Route::get('order', 'Admin\OrderController@index');
        Route::get('order/{id}', 'Admin\OrderController@show');
        Route::post('order/{id}/deliver', 'Admin\OrderController@deliverOrder');
        Route::post('order/{id}/rejected', 'Admin\OrderController@rejected');
        Route::post('order/{id}/exchange', 'Admin\OrderController@exchange');
        Route::post('order/{id}/deny', 'Admin\OrderController@deny');

        //Cash
        Route::get('cash', 'Admin\CashController@index');
        Route::post('cash/accept', 'Admin\CashController@accept');

        //Latest 最新商品
        Route::get('latest/edit', 'Admin\LatestController@index');
        Route::post('latest/store', 'Admin\LatestController@store');
        Route::any('latest/destroy', 'Admin\LatestController@destroyAll');

        //Group
        Route::get('group/create', 'Admin\GroupController@create');
        Route::post('group/store', 'Admin\GroupController@store');
        Route::post('group/production/store', 'Admin\GroupController@storeGroupProduction');
        Route::get('group', 'Admin\GroupController@index');
        Route::delete('group/{id}', 'Admin\GroupController@destroyGroup');

        //投票
        Route::get('vote', 'Admin\VoteController@index');

        //ajax
        Route::any('ajax/image', 'Admin\Ajax\ImageController@all');
        Route::any('ajax/production', 'Admin\Ajax\ProductionController@all');
        Route::any('ajax/user/relation', 'Admin\UserController@AjaxRelation');
        Route::any('ajax/user/relation/get/root', 'Admin\UserController@getRoot');
    });

    //ajax
    Route::group(['prefix' => 'ajax'], function () {
        Route::post('get/quantity/{id}', 'ProductionController@getQuantityBySize');
    });

    //Common Controller

    //Index
    Route::get('/', 'IndexController@index');

    //Latest
    Route::get('latest', 'LatestController@index');

    Route::get('theme', 'GroupController@index');

    //User
    Route::get('/qrcode', 'UserController@getQrCode');
    Route::get('/qrcode/create', 'UserController@generateQrCode');

    //Production
    Route::get('production', 'ProductionController@index');
    Route::get('production/{id}', 'ProductionController@redirect');
    Route::get('production/{id}/{colorId}', 'ProductionController@show');

    // Order
    Route::get('order/create', 'OrderController@create');
    Route::post('order/store', 'OrderController@store');
    Route::get('order', 'OrderController@index');
    Route::get('order/{orderId}', 'OrderController@show');
    Route::post('order/{orderNo}/cancel', 'OrderController@cancel');
    Route::post('order/{orderNo}/reject', 'OrderController@reject');
    Route::post('order/{orderNo}/receive', 'OrderController@receive');

    // Address
    Route::get('address/create', 'AddressController@create');
    Route::get('address/{id}/edit', 'AddressController@edit');

    Route::post('address/store', 'AddressController@store');
    Route::post('address/{id}', 'AddressController@update');

    // QrCode
    Route::get('qrcode', 'UserController@getQrCode');

    Route::get('user', 'UserController@userCenter');
    Route::get('user/children/one', 'UserController@oneChildren');
    Route::get('user/children/second', 'UserController@secondChildren');
    Route::get('user/children/three', 'UserController@threeChildren');

//    cart
    Route::post('cart/shopping/create', 'CartController@createToShoppingCart');
    Route::post('cart/once/create', 'CartController@createToOnceCart');
    Route::get('cart/{cartName}/show', 'CartController@show');
    Route::get('cart/{cartName}/use', 'CartController@useCart');
    Route::delete('cart/shopping/{rowId}', 'CartController@remove');
    Route::post('cart/buy', 'CartController@cartBuy');

    //Draw 提现
    Route::get('draw', 'DrawController@index');
    Route::post('draw/store', 'DrawController@store');

    //Vote 投票
    Route::get('vote', 'VoteController@index');
    Route::post('vote', 'VoteController@store');
    Route::get('vote/result', 'VoteController@result');


    Route::get('image/share', 'ImageController@index');
    Route::get('image/{id}/show', 'ImageController@show');
});

Route::post('admin/ajax/image/store', 'Admin\Ajax\ImageController@store');

Route::group([
    'prefix' => 'wechat',
    'middleware' => 'wechat',
], function () {
    Route::any('server', 'Wechat\ServerController@index');
    Route::any('login', 'Wechat\AuthController@index');
    Route::any('auth/callback', 'Wechat\AuthController@callback');
    Route::any('menu/update', 'Wechat\MenuController@index');
    Route::any('pay/notify', 'OrderController@notify');
    Route::any('notice/pay/{$openid}/{$orderId}', 'Wechat\NoticeController@paySuccess');


    Route::group([
        'middleware' => 'auth',
    ], function () {
        Route::any('pay/{wechatOrderNo}', 'Wechat\PayController@pay');
        Route::any('refund/{wechatOrderNo}', 'Wechat\PayController@refund');
        Route::any('cash', 'Wechat\PayController@getCash');
    });
});
