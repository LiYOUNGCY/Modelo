<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Storage;

class TestController extends Controller
{
    public function index(Request $request, $id, $cid)
    {
        echo $id, $cid;
    }

    public function store(Request $request)
    {
        return response()->json([
            'data' => $request->all(),
        ]);
    }
}
