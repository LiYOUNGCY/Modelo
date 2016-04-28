<?php

namespace App\Http\Controllers;

use App\Model\Latest;
use App\Model\Series;
use Illuminate\Http\Request;

use App\Http\Requests;

class LatestController extends Controller
{
    public function index()
    {
        $data = Latest::get();
        $series = Series::getAll();
//        var_dump($data);
//        echo \GuzzleHttp\json_encode($data);
        return view('latest.index', [
            'data' => $data,
            'series' => $series,
        ]);
    }
}
