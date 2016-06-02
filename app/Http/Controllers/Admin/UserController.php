<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\NotFoundException;
use App\Http\Controllers\AdminController;
use App\Model\User;
use Illuminate\Http\Request;
use Log;
use App\Http\Requests;
use DB;

class UserController extends AdminController
{

    public function index()
    {
        $users = User::all();

        return view('admin.user.index', [
            'users' => $users,
        ]);
    }

    public function show(Request $request, $id)
    {
        $user = User::find($id);

        $oneCount = User::getChildrenCount($user->id);
        $oneBuyCount = User::getChildrenBuyCount($user->id);
        $secondCount = User::getSecondCount($user->id);
        $secondBuyCount = User::getSecondBuyCount($user->id);
        $threeCount = User::getThreeCount($user->id);
        $threeBuyCount = User::getThreeBuyCount($user->id);
        $consume = User::getConsume($user->id);

        $count = $oneCount + $secondCount + $threeCount;
        $buyCount = $oneBuyCount + $secondBuyCount + $threeBuyCount;

        return view('admin.user.show', [
            'user' => $user,

            'sales' => User::getFinishOrderTotal($user->id),
            'unpaid' => User::getUnpaidOrderTotal($user->id),
            'unFinish' => User::getUnFinishOrderTotal($user->id),

            'oneCount' => $oneCount,
            'oneBuyCount' => $oneBuyCount,
            'secondCount' => $secondCount,
            'secondBuyCount' => $secondBuyCount,
            'threeCount' => $threeCount,
            'threeBuyCount' => $threeBuyCount,
            'count' => $count,
            'buyCount' => $buyCount,
            'consume' => $consume,
        ]);
    }


    /**
     * 将某个用户改为推广人员
     * @param $id
     * @return mixed
     */
    public function changeSuper($id)
    {
        try {
            $user = User::get($id);
            $user->changeSuper();
        } catch (NotFoundException $e) {
            Log::warning($e->getMessage());

            return response()->json([
                'error' => 0,
                'message' => $e->getMessage(),
            ]);
        }

        return response()->json([
            'success' => 0,
        ]);
    }

    public function relation()
    {
        return view('admin.user.relation');
    }

    public function AjaxRelation(Request $request)
    {
        $selfId = $request->get('id');
        $data = DB::table('user_relation')
            ->join('user', 'user_relation.children_id', '=', 'user.id')
            ->where('user_relation.parent_id', '=', $selfId)
            ->select(
                'user.id',
                'user.nickname as text'
            )
            ->get();

        foreach ($data as $key => $value) {
            $data[$key]->children = true;
        }

        return response()->json($data);
    }

    public function getRoot()
    {
        return response()->json([
            'id' => 1,
            'text' => '魔豆树',
            'children' => true,
        ]);
    }
}
