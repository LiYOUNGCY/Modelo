<?php


Route::group(['middleware' => ['web']], function () {

    Route::get('test/{id}/{cid}', 'TestController@index');
    Route::post('test', 'TestController@store');

    Route::group(['prefix' => \Illuminate\Support\Facades\Config::get('constants.route.admin')], function () {
        Route::get('/', function () {
            return view('welcome');
        });

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
    });

    //ajax
    Route::group(['prefix' => 'ajax'], function(){
        Route::post('get/quantity/{id}', 'ProductionController@getQuantityBySize');
    });

    //Common Controller
    Route::get('production/{alias}', 'ProductionController@show');
    Route::get('buy/{alias}', 'ProductionController@redirect');
    Route::get('buy/{alias}/{colorAlias}', 'ProductionController@buy');
});
