<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Config;

class Profit extends Model
{
    protected $table = 'profit';

    public function status()
    {
        return $this->belongsTo('App\Model\ProfitStatus', 'status_id');
    }

    public function level()
    {
        return $this->belongsTo('App\Model\ProfitLevel', 'level_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Model\User', 'user_id');
    }

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

        if ($level_id != Config::get('constants.levelName.three')) {
            DB::table('user')
                ->where('user.id', '=', $user_id)
                ->increment('freeze_total', $profit);
        } else {
            DB::table('user')
                ->where('user.id', '=', $user_id)
                ->increment('freeze_three', $profit);
        }

        /**
         * 总的奖励金额
         */
        DB::table('user')
            ->where('user.id', '=', $user_id)
            ->increment('total', $profit);
    }

    /**
     * 将冻结金额转为可用金额
     * @param $order_id
     */
    public static function removeFreeze($order_id)
    {
        $profits = Profit::where('order_id', '=', $order_id)->get();
        foreach ($profits as $profit) {
            $user_id = $profit->user_id;

            if ($profit->level_id != Config::get('constants.levelName.three')) {
                $canGet = $profit->status_id == Config::get('constants.profitStatus.freeze');
                $profit->status_id = Config::get('constants.profitStatus.available');
                $profit->save();

                if (isset($profit) && $canGet) {
                    $profit = $profit->profit;

                    DB::table('user')
                        ->where('user.id', '=', $user_id)
                        ->where('freeze_total', '>=', $profit)
                        ->increment('available_total', $profit);

                    DB::table('user')
                        ->where('user.id', '=', $user_id)
                        ->decrement('freeze_total', $profit);
                }
            } else {
                if (User::getFinishOrderTotal($user_id) >= Config::get('constants.salesVolume')) {
                    $canGet = $profit->status_id == Config::get('constants.profitStatus.freeze');
                    $profit->status_id = Config::get('constants.profitStatus.available');
                    $profit->save();

                    if (isset($profit) && $canGet) {
                        $profit = $profit->profit;

                        DB::table('user')
                            ->where('user.id', '=', $user_id)
                            ->where('freeze_three', '>=', $profit)
                            ->increment('available_total', $profit);

                        DB::table('user')
                            ->where('user.id', '=', $user_id)
                            ->decrement('freeze_three', $profit);
                    }
                }
            }
        }
    }

    /**
     * @param $orderId
     * @return array
     */
    public static function getByOrderId($orderId)
    {
        $result = Profit::where('order_id', $orderId)->get();
        return $result;
    }

    /**
     * 将奖励金额取消
     * @param $orderId
     */
    public static function removeProfit($orderId)
    {
        $profits = Profit::where('order_id', $orderId)->get();

        foreach ($profits as $profit) {
            //三级的奖励就从三级的冻结金额去除
            if($profit->level_id == Config::get('constants.levelName.three')
            && $profit->status_id == Config::get('constants.profitStatus.freeze')) {
                DB::table('user')
                    ->where('id', $profit->user_id)
                    ->where('freeze_three', '>=', $profit->profit)
                    ->decrement('freeze_three', $profit->profit);
            } else {
                DB::table('user')
                    ->where('id', $profit->user_id)
                    ->where('freeze_total', '>=', $profit->profit)
                    ->decrement('freeze_total', $profit->profit);
            }

            //从总金额里去除
            DB::table('user')
                ->where('id', $profit->user_id)
                ->where('total', '>=', $profit->profit)
                ->decrement('total', $profit->profit);


            //状态变为：cancel
            $profit->status_id = Config::get('constants.profitStatus.cancel');
            $profit->save();
        }
    }
}
