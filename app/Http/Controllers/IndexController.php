<?php

namespace App\Http\Controllers;

use App\Model\Production;
use Illuminate\Http\Request;

use App\Http\Requests;

class IndexController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function deny()
    {
        return view('deny');
    }
}
