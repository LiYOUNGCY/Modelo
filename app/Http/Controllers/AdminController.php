<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Config;

class AdminController extends Controller
{
    protected $ADMIN;

    public function __construct()
    {
        $this->ADMIN = Config::get('constants.route.admin');
    }
}
