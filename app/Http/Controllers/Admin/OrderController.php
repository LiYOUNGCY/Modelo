<?php

namespace App\Http\Controllers\Admin;

use App\Model\Order;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->get('page');
        $page = is_null($page) ? 1 : $page;
        $orders = Order::getAll($page);

        return view('admin.order.index', [
            'orders' => $orders,
            'page' => Order::getAllPage(),
            'nowPage' => $page,
        ]);
    }
}
