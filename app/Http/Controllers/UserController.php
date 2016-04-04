<?php

namespace App\Http\Controllers;

use App\Container\Container;
use App\Model\UserQrCode;
use Illuminate\Http\Request;
use App\Http\Requests;

class UserController extends Controller
{
    public function getQrCode()
    {
        $user = Container::getUser();

        //@TODO need judge user is buy a production.
        if($user->can_qrcode) {
            if (!UserQrCode::hasQrCode($user->id)) {
                UserQrCode::generateQrCode($user->id);
            }

            return view('qrcode.show', [
                'qrcode' => UserQrCode::getQrCode($user->id),
            ]);
        } else {
            echo 'no qrcode';
        }
    }
}
