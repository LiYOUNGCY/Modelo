<?php

namespace App\Http\Controllers;

use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Requests;

class TestController extends Controller
{
    public function index(Request $request)
    {
//        echo User::getSecondCount(1);
//        echo User::getSecondBuyCount(1);
//
//        echo User::getThreeCount(1);
//        echo User::getThreeBuyCount(1);

        $user = User::findOrNewByOpenid('o4-YOwBjMKaYE8MiUT_vHHZP2oHg');
        var_dump($user);
    }
}
