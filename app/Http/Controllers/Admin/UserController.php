<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Model\User;
use Illuminate\Http\Request;

use App\Http\Requests;

class UserController extends AdminController
{
    //将某个用户改为推广人员
    public function changeSuper($id)
    {
        User::changeSuper($id);
        return response()->json([
            'success' => 0,
        ]);
    }
}
