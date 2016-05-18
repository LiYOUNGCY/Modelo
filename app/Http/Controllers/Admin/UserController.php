<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\NotFoundException;
use App\Http\Controllers\AdminController;
use App\Model\User;
use Illuminate\Http\Request;
use Log;
use App\Http\Requests;

class UserController extends AdminController
{

    public function index()
    {
        $users = User::all();

        return view('admin.user.index', [
            'users' => $users,
        ]);
    }

    public function show(Request $request, $id)
    {
        $user = User::find($id);

        $oneCount = User::getChildrenCount($user->id);
        $oneBuyCount = User::getChildrenBuyCount($user->id);
        $secondCount = User::getSecondCount($user->id);
        $secondBuyCount = User::getSecondBuyCount($user->id);
        $threeCount = User::getThreeCount($user->id);
        $threeBuyCount = User::getThreeBuyCount($user->id);
        $consume = User::getConsume($user->id);

        $count = $oneCount + $secondCount + $threeCount;
        $buyCount = $oneBuyCount + $secondBuyCount + $threeBuyCount;

        return view('admin.user.show', [
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


    /**
     * 将某个用户改为推广人员
     * @param $id
     * @return mixed
     */
    public function changeSuper($id)
    {
        try {
            $user = User::get($id);
            $user->changeSuper();
        } catch (NotFoundException $e) {
            Log::warning($e->getMessage());

            return response()->json([
                'error' => 0,
                'message' => $e->getMessage(),
            ]);
        }

        return response()->json([
            'success' => 0,
        ]);
    }
}
