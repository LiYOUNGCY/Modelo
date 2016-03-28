<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Config;

class Profit extends Model
{
    protected $table = 'profit';

    public static function insert($user_id, $order_id, $level_id, $profit)
    {
        DB::table('profit')
            ->insert([
                'user_id' => $user_id,
                'order_id' => $order_id,
                'status_id' => Config::get('constants.profitStatus.freeze'),
                'level_id' => $level_id,
                'profit' => $profit,
            ]);

        DB::table('user')
            ->where('user.id', '=', $user_id)
            ->increment('freeze_total', $profit);
    }

    public static function removeFreeze($order_id)
    {
        $profit = Profit::where('order_id', '=', $order_id)->first();
        $profit->status = Config::get('constants.profitStatus.available');
        $profit->save();
        
        if(isset($profit)) {
            $user_id = $profit->user_id;
            $profit = $profit->profit;

            DB::table('user')
                ->where('user.id', '=', $user_id)
                ->increment('available_total', $profit);

            DB::table('user')
                ->where('user.id', '=', $user_id)
                ->decrement('freeze_total', $profit);
        }
    }
}
