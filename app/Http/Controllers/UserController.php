<?php

namespace App\Http\Controllers;

use App\Container\Container;
use App\Model\User;
use App\Model\UserQrCode;
use Illuminate\Http\Request;
use App\Http\Requests;

class UserController extends Controller
{
    public function getQrCode()
    {
        $user = Container::getUser();

        //@TODO need judge user is buy a production.
        if ($user->can_qrcode) {
            if (!UserQrCode::hasQrCode($user->id)) {
                UserQrCode::generateQrCode($user->id);
            }

            return view('qrcode.show', [
                'qrcode' => UserQrCode::getQrCode($user->id),
            ]);
        } else {
            return view('qrcode.deny');
        }
    }

    public function userCenter()
    {
        $user = Container::getUser();

        $oneCount = User::getChildrenCount($user->id);
        $oneBuyCount = User::getChildrenBuyCount($user->id);
        $secondCount = User::getSecondCount($user->id);
        $secondBuyCount = User::getSecondBuyCount($user->id);
        $threeCount = User::getThreeCount($user->id);
        $threeBuyCount = User::getThreeBuyCount($user->id);
        $consume = User::getConsume($user->id);

        $count = $oneCount + $secondCount + $threeCount;
        $buyCount = $oneBuyCount + $secondBuyCount + $threeBuyCount;

        return view('user.center', [
            'user' => $user,
            'sales' => User::getFinishOrderTotal($user->id),
            'unpaid' => User::getUnpaidOrderTotal($user->id),
            'unFinish' => User::getUnFinishOrderTotal($user->id),

            'oneCount' => $oneCount,
            'oneBuyCount' => $oneBuyCount,
            'secondCount' => $secondCount,
            'secondBuyCount' => $secondBuyCount,
            'threeCount' => $threeCount,
            'threeBuyCount' => $threeBuyCount,
            'count' => $count,
            'buyCount' => $buyCount,
            'consume' => $consume,
        ]);
    }
}
