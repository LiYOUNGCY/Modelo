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
            ->increment('freeze_total', $profit);
    }
}
