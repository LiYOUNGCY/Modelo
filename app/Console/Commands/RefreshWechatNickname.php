<?php

namespace App\Console\Commands;

use App\Model\User;
use Illuminate\Console\Command;

class RefreshWechatNickname extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'refresh:nickname';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        echo "Refreshing...\n";
        $app = app('wechat');
        $userService = $app->user;
        $users = User::all();
        foreach ($users as $user) {
            if (!empty($user->openid)) {
                $info = $userService->get($user->openid);
                $user->nickname = $info->nickname;
                $user->save();
            }
        }
        echo "Complete!\n";
    }
}
