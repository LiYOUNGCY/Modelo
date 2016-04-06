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
            $parent = UserQrCode::getByToken($token);
            if (isset($parent)) {
                $parentId = $parent->user->id;
                $referee = $parent->user->nickname;

                $userRelation = new UserRelation();
                $userRelation->insert($user->id, $parentId);

                $user->scanQrcode($referee);

                return redirect('/');
            } else {
                abort(503, '无效的二维码');
            }
        } else {
            return redirect('/');
        }
    }
}
