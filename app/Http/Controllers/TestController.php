<?php

namespace App\Http\Controllers;

use App\Model\Order;
use Illuminate\Http\Request;

use App\Http\Requests;

class TestController extends Controller
{
    public function index(Request $request)
    {
        Order::cancelOrder();
    }

    public function store(Request $request)
    {
        return response()->json([
            'data' => $request->all(),
        ]);
    }
}
