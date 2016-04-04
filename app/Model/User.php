<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class User extends Model
{
    protected $table = 'user';

    public function address()
    {
        return $this->hasOne('App\Model\UserAddress', 'user_id');
    }

    public function relation()
    {
        return $this->hasOne('App\Model\UserRelation', 'children_id');
    }

    public static function canBuy($user_id, $referee)
    {
        $user = User::find($user_id);
        $user->can_buy = true;
        $user->referee = $referee;
        $user->save();
    }

    public static function canQrcode($user_id)
    {
        $user = User::find($user_id);
        $user->can_qrcode = true;
        $user->save();
    }

    public static function changeSuper($user_id)
    {
        $user = User::find($user_id);
        $user->can_qrcode = true;
        $user->get_qrcode = false;  //禁止扫描其他人的二维码
        $user->save();
    }

    /**
     * 禁止扫描其他的二维码
     */
    public function removeScan()
    {
        $this->get_qrcode = false;
        $this->save();
    }
}
