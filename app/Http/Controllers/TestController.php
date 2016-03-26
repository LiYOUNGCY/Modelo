<?php

namespace App\Http\Controllers;

use App\Model\Image;
use App\Model\Order;
use App\Model\UserRelation;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Storage;

class TestController extends Controller
{
    public function index(Request $request)
    {
        UserRelation::belongTo(1, 'YUZSUnF4WUZxRnBOd05pMVZDeTJmZjdId0JsQk4xeTU=');
    }

    public function store(Request $request)
    {
        return response()->json([
            'data' => $request->all(),
        ]);
    }
}
