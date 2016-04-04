<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

//$factory->define(App\User::class, function (Faker\Generator $faker) {
//    return [
//        'name' => $faker->name,
//        'email' => $faker->safeEmail,
//        'password' => bcrypt(str_random(10)),
//        'remember_token' => str_random(10),
//    ];
//});

$factory->define(App\Model\Order::class, function (Faker\Generator $faker) {
    return [
        'user_id' => 1,
        'order_no' => str_random(32),
        'phone' => 12345678901,
        'contact' => '玻璃侠',
        'address' => '广东省广州市从化区太平镇东风村 13 号',
        'total' => 123,
        'status' => \Illuminate\Support\Facades\Config::get('constants.orderStatus.paid'),
        'last_action_at' => date('Y-m-d H:i:s'),
    ];
});
