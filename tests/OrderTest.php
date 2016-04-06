<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class OrderTest extends TestCase
{
//    public function testCreateOrder()
//    {
//        $order = factory(App\Model\Order::class, 100000)->create();
//    }

    public function testGetUnpaidAndCancelOrderTotal()
    {
        var_dump(\App\Model\User::getUnpaidAndCancelOrderTotal(1));
        var_dump(\App\Model\User::getFinishOrderTotal(1));
        var_dump(\App\Model\User::getUnFinishOrderTotal(1));
    }
}
