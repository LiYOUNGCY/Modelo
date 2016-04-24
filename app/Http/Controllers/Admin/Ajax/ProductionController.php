<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Http\Controllers\AdminController;
use App\Model\Production;
use Illuminate\Http\Request;

use App\Http\Requests;

class ProductionController extends AdminController
{
    public function all()
    {
        $production = Production::all();

        return response()->json([
            'success' => 0,
            'data' => $production,
        ]);
    }
}
