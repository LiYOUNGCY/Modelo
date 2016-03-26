<?php

namespace App\Http\Controllers;

use App\Model\Production;
use Illuminate\Http\Request;

use App\Http\Requests;

class IndexController extends Controller
{
    public function index()
    {
        $productions = Production::getAll();
        return view('index', [
            'productions' => $productions,
        ]);
    }
}
