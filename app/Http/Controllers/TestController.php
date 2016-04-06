<?php

namespace App\Http\Controllers;

use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Requests;

class TestController extends Controller
{
    public function index(Request $request)
    {
        $user = User::findOrNew(2);
//        $user->changeSuper();
        $user->nickname = '2';
        $user->save();
    }
}
