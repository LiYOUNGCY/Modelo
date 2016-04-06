<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\NotFoundException;
use App\Http\Controllers\AdminController;
use App\Model\User;
use Illuminate\Http\Request;
use Log;
use App\Http\Requests;

class UserController extends AdminController
{
    /**
     * 将某个用户改为推广人员
     * @param $id
     * @return mixed
     */
    public function changeSuper($id)
    {
        try {
            $user = User::get($id);
            $user->changeSuper();
        } catch (NotFoundException $e) {
            Log::warning($e->getMessage());

            return response()->json([
                'error' => 0,
                'message' => $e->getMessage(),
            ]);
        }

        return response()->json([
            'success' => 0,
        ]);
    }
}
