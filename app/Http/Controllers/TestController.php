<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App;

class TestController extends Controller
{
    public function index(Request $request)
    {
        App\Container\Container::setUser(1);
        var_dump(App\Container\Container::getUser());
    }

    public function store(Request $request)
    {
        return response()->json([
            'data' => $request->all(),
        ]);
    }
}
