<?php

namespace App\Http\Controllers;

use App\Model\UserQrCode;
use App\Model\UserRelation;
use App\Container\Container;
use App\Http\Requests;

class QrCodeController extends Controller
{
    /**
     * 扫描二维码
     * @param $token
     * @return mixed
     */
    public function scan($token)
    {
        $user = Container::getUser();

        if ($user->get_qrcode) {
            $parentId = UserQrCode::getByToken($token);
            if(isset($parentId)) {
                $parentId = $parentId->user->id;
                $userRelation = new UserRelation();
                $userRelation->insert($user->id, $parentId);
                $user->removeScan();

                return redirect('/');
            } else {
                abort(503, '无效的二维码');
            }
        } else {
            return redirect('/');
        }
    }
}
