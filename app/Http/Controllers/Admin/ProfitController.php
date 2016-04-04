<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Http\Requests;

class ProfitController extends AdminController
{
    public function index()
    {
        return view('admin.profit.index');
    }
}
