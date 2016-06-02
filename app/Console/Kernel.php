<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\CancelOrder::class,
        Commands\ConfirmOrder::class,
        Commands\Install::class,
        Commands\ReceivedOrder::class,
        Commands\FinishOrder::class,
        Commands\RefreshWechatNickname::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('order:cancel')
            ->everyMinute();

        $schedule->command('order:confirm')
            ->everyMinute();
        
        $schedule->command('order:received')
            ->everyMinute();
        
        $schedule->command('order:finish')
            ->everyMinute();
    }
}
