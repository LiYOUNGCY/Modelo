<?php

namespace App\Http\Controllers;

use App\Container\Container;
use App\Model\Cash;
use App\Model\User;
use Illuminate\Http\Request;

use App\Http\Requests;

class DrawController extends Controller
{
    public function index()
    {
        $user = Container::getUser();
        $cash = Cash::where('user_id', $user->id)->orderBy('id', 'desc')->get();

        return view('cash.index', [
            'cash' => $cash,
        ]);
    }

    public function store(Request $request)
    {
        $count = $request->get('withdraw');

        if(is_int($count)) {
            return response()->json([
                'error' => 0,
                'message' => '请输入整数',
            ]);
        }
        $user = Container::getUser();

        $total = $user->available_total;

        if(User::getFinishOrderTotal($user->id) >= Config::get('constants.salesVolume')) {
            $total += $user->available_three;
        }

        if($count <= $total) {
            $temp = $count;
            if($user->available_total >= $count) {
                $user->available_total -= $count;
            } else {
                $temp -= $user->available;
                $user->available = 0;
                $user->available_three -= $temp;
            }
            $user->save();
        } else {
            return response()->json([
                'error' => 0,
                'msg' => '你没有足够的可用金额',
            ]);
        }

        return response()->json(['success' => 0]);
    }
}
