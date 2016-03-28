<?php

namespace App\Console\Commands;

use App\Model\Order;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

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
        Log::info("[ORDER] received is running");
        Order::receivedOrder();
    }
}
