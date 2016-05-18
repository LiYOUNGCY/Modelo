<?php

namespace App\Console\Commands;

use App\Model\Order;
use App\Model\Profit;
use Illuminate\Console\Command;
use Log;

class FinishOrder extends Command
{
    protected $signature = 'order:finish';

    protected $description = 'finish order';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        Log::info('[ORDER] finish order is running');
        $orders = Order::getFinishOrder();

        foreach ($orders as $order) {
            Profit::removeFreeze($order->id);
        }

        Order::finishOrder();
    }
}
