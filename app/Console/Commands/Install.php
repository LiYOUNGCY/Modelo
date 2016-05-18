<?php

namespace App\Console\Commands;

use App\Model\ProductionCategory;
use App\Model\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Hash;

class Install extends Command
{
    protected $signature = 'install';

    protected $description = 'setup app';

    public function __construct()
    {
        parent::__construct();
    }

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
                    'name' => '待发货',
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
                    'name' => '已退货',
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

        DB::table('cash_status')
            ->insert([
                [
                    'id' => Config::get('constants.CashStatus.pending'),
                    'name' => '等待审核',
                ],
                [
                    'id' => Config::get('constants.CashStatus.accept'),
                    'name' => '提现成功',
                ],
                [
                    'id' => Config::get('constants.CashStatus.reject'),
                    'name' => '提现失败',
                ],
            ]);

        $this->createCategory(1, '上身');
        $this->createCategory(2, '下身');
        $this->createCategory(3, '连体');

        $user = new User();
        $user->id = 1;
        $user->nickname = '魔豆树';
        $user->password = Hash::make('whoisyourdaddy');
        $user->save();
    }

    private function createCategory($id, $name)
    {
        $category = new ProductionCategory();
        $category->id = $id;
        $category->name = $name;
        $category->save();
    }
}
