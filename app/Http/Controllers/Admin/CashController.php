<?php

namespace App\Http\Controllers\Admin;

use App\Container\Container;
use App\Http\Controllers\AdminController;
use App\Model\Cash;
use Illuminate\Http\Request;

use App\Http\Requests;
use Config;

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
        $user = Container::getUser();

        if (isset($cash) && $cash->status_id == Config::get('constants.CashStatus.pending')) {
            $cash->status_id = Config::get('constants.CashStatus.accept');
            //Send money
            $app = app('wechat');
            $luckyMoney = $app->lucky_money;

            $luckyMoneyData = [
                'mch_billno' => 'Mods' . time(),
                'send_name' => '恭喜发财',
                're_openid' => $user->openid,
                'total_amount' => $cash->cash * 100,
//                'wishing'          => '',
//                'act_name'         => '测试活动',
//                'remark'           => '测试备注',
                // ...
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
