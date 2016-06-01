<?php

namespace App\Console\Commands;

use App\Model\Profit;
use App\Model\UserRelation;
use Illuminate\Console\Command;
use Config;
use App\Model\Order;
use App\Model\User;
use Log;
use DB;

class ConfirmOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:confirm';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Confirm the order';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $orders = Order::getPaid();
        foreach ($orders as $order) {
            //判断用户买了是否买了两件以上的商品
            if(Order::getBuyCount($order->user_id) >= 2 ) {
                User::get($order->user_id)->canQrcode();
            }

            try {
                $parent = $this->setProfit($order->user_id, $order, 'one');
                $parent = $this->setProfit($parent->parent, $order, 'two');
                $this->setProfit($parent->parent, $order, 'three');
            } catch (\Exception $e) {
                Log::info($e->getMessage());
            }
        }

        Order::confirmOrder();
    }

    public function setProfit($user_id, $order, $level)
    {
        $parent = UserRelation::getParent($user_id);
        if (isset($parent)) {
            Profit::insert(
                $parent->parent,
                $order->id,
                Config::get("constants.levelName.{$level}"),
                $order->total * Config::get("constants.profit.{$level}")
            );
            return $parent;
        } else {
            throw new \Exception('Not parent');
        }
    }
}
