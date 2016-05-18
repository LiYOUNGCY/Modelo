<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Model\Cash;
use Illuminate\Http\Request;
use App\Http\Requests;
use Config;
use App\Model\User;

class CashController extends AdminController
{
    public function index(Request $request)
    {
        $id = $request->get('status');

        if (is_null($id)) {
            $data = Cash::all();
        } else {
            $data = Cash::where('status_id', $id)->get();
        }

        return view('admin.cash.index', [
            'data' => $data,
        ]);
    }

    public function accept(Request $request)
    {
        $id = $request->get('id');

        $cash = Cash::find($id);
        $user = User::find($cash->user_id);

        if (isset($cash) && $cash->status_id == Config::get('constants.CashStatus.pending')) {
            $cash->status_id = Config::get('constants.CashStatus.accept');
            $cash->save();

            $user->used_total += $cash->cash;
            $user->save();

            //Send money
            $app = app('wechat');
            $luckyMoney = $app->lucky_money;

            $luckyMoneyData = [
                'mch_billno' => 'Mods' . time(),
                'send_name' => '魔豆树',
                're_openid' => $user->openid,
                'total_amount' => $cash->cash * 100,
                'wishing' => '分享提现',
                'act_name' => '魔豆树',
                'remark' => '愿您的魔豆种子茁壮成长。',
            ];

            $luckyMoney->sendNormal($luckyMoneyData);

            return response()->json([
                'success' => 0,
            ]);
        }

        return response()->json([
            'error' => 0,
        ]);
    }
}
