<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'setup app';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        DB::table('order_status')
            ->insert([
                [
                    'id' => Config::get('constants.orderStatus.cancel'),
                    'name' => '取消订单',
                ],
                [
                    'id' => Config::get('constants.orderStatus.unpaid'),
                    'name' => '未支付',
                ],
                [
                    'id' => Config::get('constants.orderStatus.paid'),
                    'name' => '已支付',
                ],
                [
                    'id' => Config::get('constants.orderStatus.confirm'),
                    'name' => '确认订单',
                ],
                [
                    'id' => Config::get('constants.orderStatus.deliver'),
                    'name' => '已发货',
                ],
                [
                    'id' => Config::get('constants.orderStatus.received'),
                    'name' => '已收货',
                ],
                [
                    'id' => Config::get('constants.orderStatus.finish'),
                    'name' => '已完成',
                ],
                [
                    'id' => Config::get('constants.orderStatus.reject'),
                    'name' => '售后处理中',
                ],
                [
                    'id' => Config::get('constants.orderStatus.rejected'),
                    'name' => '确认退货',
                ],
                [
                    'id' => Config::get('constants.orderStatus.exchange'),
                    'name' => '准备重新发货',
                ],
            ]);

        DB::table('profit_status')
            ->insert([
                [
                    'id' => Config::get('constants.profitStatus.cancel'),
                    'name' => '取消',
                ],
                [
                    'id' => Config::get('constants.profitStatus.available'),
                    'name' => '可用金额',
                ],
                [
                    'id' => Config::get('constants.profitStatus.freeze'),
                    'name' => '冻结金额',
                ],
            ]);

        DB::table('profit_level')
            ->insert([
                [
                    'id' => Config::get('constants.levelName.one'),
                    'name' => '一级利润',
                ],
                [
                    'id' => Config::get('constants.levelName.two'),
                    'name' => '二级利润',
                ],
                [
                    'id' => Config::get('constants.levelName.three'),
                    'name' => '三级利润',
                ],
            ]);
        
    }
}
