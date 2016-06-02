<?php

namespace App\Console\Commands;

use App\Model\Order;
use Illuminate\Console\Command;
use Log;

class ReceivedOrder extends Command
{
    protected $signature = 'order:received';

    protected $description = 'received order';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        Order::receivedOrder();
    }
}
