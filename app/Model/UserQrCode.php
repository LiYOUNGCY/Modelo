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
        $app = app('wechat');
        $qrcode = $app->qrcode;

        $token = self::count() + 1;

        $result = $qrcode->temporary($token, 7*24*3600);
        $ticket = $result->ticket;
        $url = $qrcode->url($ticket);
        $content = file_get_contents($url);

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
            ->where('user_qrcode.user_id', '=', $user_id)
            ->select(
                'image.path as qrcode'
            )
            ->first();
        
        return $query;
    }

    public static function count()
    {
        $count = DB::table('user_qrcode')
            ->count();

        return $count;
    }
}
