<?php

namespace App\Http\Controllers;

use App\Container\Container;
use App\Http\Common;
use App\Jobs\SendWechatMessage;
use App\Model\Order;
use App\Model\Profit;
use App\Model\User;
use App\Model\UserQrCode;
use Illuminate\Http\Request;
use App\Http\Requests;
use Config;
use Cookie;
use Log;
use Session;
use DB;
use Illuminate\Http\Response;
use EasyWeChat\Message\Text;
use EasyWeChat\Message\News;

class TestController extends Controller
{
	public function index(Request $request)
	{
//		$app = app('wechat');
//		$userService = $app->user;
//		$users = User::all();
//		foreach ($users as $user) {
//			if(!empty($user->openid)) {
//				$info = $userService->get($user->openid);
//				$first_name = preg_replace('~\xEE[\x80-\xBF][\x80-\xBF]|\xEF[\x81-\x83][\x80-\xBF]~', '', $info->nickname);
//				$user->nickname = $first_name;
//				$user->save();
//			}
//		}

		$users = User::all();

		foreach ($users as $user) {
			$referee = DB::table('user')
				->join('user_relation', 'user_relation.parent_id', '=', 'user.id')
				->where('user_relation.children_id', $user->id)
				->select('user.nickname')
				->first();

			var_dump($referee);
//			$user->referee = $referee;
		}
	}
	public function login(Request $request)
	{
		$user = User::find(1);

		if (is_null($user)) {
			throw new \Exception("请运行 install .");
		}

		Container::setUser($user->id);

		Common::createLoginCookie();

#Log::info("user: {$user->id}");

		echo 'Success';
	}

	public function logout(Request $request)
	{
		Session::forget('user');
		$cookieName = Config::get('constants.rememberCookie');
		Cookie::queue($cookieName, null, -1); // 销毁
	}

	public function check()
	{
		$session = session()->get('user');
		echo '<pre>';
		print_r($session);
		echo '</pre>';

		$cookieName = Config::get('constants.rememberCookie');
		$cookie = Cookie::get($cookieName);
		echo '<pre>';
		print_r($cookie);
		echo '</pre>';
	}

	public function pay()
	{
		$wechat_order_no = '1462067555I4pKwTEBVDK0qzvKHIkgGB';
		Order::payOrder($wechat_order_no);
	}
}
