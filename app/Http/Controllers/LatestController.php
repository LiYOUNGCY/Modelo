<?php

namespace App\Http\Controllers;

use App\Model\Latest;
use Illuminate\Http\Request;

use App\Http\Requests;

class LatestController extends Controller
{
    public function index()
    {
        $data = Latest::get();
//        var_dump($data);
//        echo \GuzzleHttp\json_encode($data);
        return view('latest.index', [
            'data' => $data,
        ]);
    }
}
