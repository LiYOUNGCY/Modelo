<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use QrCode;

class UserQrCode extends Model
{
    protected $table = 'user_qrcode';

    public function user()
    {
        return $this->belongsTo('App\Model\User', 'user_id');
    }

    public static function getByToken($token)
    {
        return UserQrCode::where('token', $token)->first();
    }

    public static function hasQrCode($user_id)
    {
        $count = DB::table('user_qrcode')
            ->where('user_qrcode.user_id', '=', $user_id)
            ->count();

        return $count === 1;
    }

    public static function generateQrCode($user_id)
    {
        $token = base64_encode(str_random(32));
        $url = url("/");
        QrCode::format('png');
        QrCode::size(200);
        QrCode::margin(2);
        QrCode::errorCorrection('H');
        $content = QrCode::generate("{$url}");

        $image = new Image();
        $image->storeImage('QrCode', $content, 'png', false);

        $user_qrcode = new UserQrCode();
        $user_qrcode->user_id = $user_id;
        $user_qrcode->image_id = $image->id;
        $user_qrcode->token = $token;
        $user_qrcode->save();
    }

    public static function getQrCode($user_id)
    {
        $query = DB::table('user_qrcode')
            ->join('image', 'image.id', '=', 'user_qrcode.image_id')
            ->select(
                'image.path as qrcode'
            )
            ->first();
        return $query;
    }
}
