<?php

namespace App\Http\Controllers;

use App\Model\User;
use App\Model\UserQrCode;
use Illuminate\Http\Request;
use App\Http\Requests;

class UserController extends Controller
{
    public function getQrCode()
    {
        $user_id = User::getUser()['id'];

        //@TODO need judge user is buy a production.
        if(User::getUser()['can_qrcode']) {
            if (!UserQrCode::hasQrCode($user_id)) {
                UserQrCode::generateQrCode($user_id);
            }

            return view('qrcode.show', [
                'qrcode' => UserQrCode::getQrCode($user_id),
            ]);
        } else {
            echo 'no qrcode';
        }
    }
}
