<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class User extends Model
{
    protected $table = 'user';

    private static $fields = [
        'id',
        'nickname',
        'can_buy',
        'can_qrcode',
        'get_qrcode',
    ];

    private static $user = [];

    public static function setUser($user)
    {
        if (is_object($user)) {
            foreach (self::$fields as $field) {
                if (isset($user->$field)) {
                    self::$user[$field] = $user->$field;
                }
            }
        } elseif (is_array($user)) {
            foreach (self::$fields as $field) {
                if (isset($user[$field])) {
                    self::$user[$field] = $user[$field];
                }
            }
        }
    }

    public static function getUser()
    {
        return self::$user;
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
}
