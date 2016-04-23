<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Model\Cash;
use Illuminate\Http\Request;

use App\Http\Requests;

class CashController extends AdminController
{
    public function index(Request $request)
    {
        $id = $request->get('status');

        if(is_null($id)) {
            $data = Cash::all();
        } else {
            $data = Cash::where('status_id', $id)->get();
        }

        return view('admin.cash.index', [
            'data' => $data,
        ]);
    }
}
