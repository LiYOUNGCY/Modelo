<?php

namespace App\Http\Controllers;

use App\Container\Container;
use App\Model\Cash;
use Illuminate\Http\Request;

use App\Http\Requests;

class DrawController extends Controller
{
    public function index()
    {
        $user = Container::getUser();
        $cash = Cash::where('user_id', $user->id)->orderBy('id', 'desc')->get();

        return view('cash.index', [
            'cash' => $cash,
        ]);
    }

    public function store(Request $request)
    {
        $count = $request->get('withdraw');
        $user = Container::getUser();

        if($count > 0 && $count <= $user->available_total) {
            Cash::create([
                'user_id' => $user->id,
                'cash' => $count,
            ]);


            $user->available_total -= $count;
            $user->save();

            return response()->json([
                'success' => 0,
            ]);
        }

        return response()->json(['error' => 0]);
    }
}
