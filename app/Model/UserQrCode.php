<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use PHPImageWorkshop\ImageWorkshop;
use Storage;
use QrCode;

class UserQrCode extends Model
{
    protected $table = 'user_qrcode';

    protected $fillable = [
        'user_id',
        'image_id',
        'token',
    ];

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

        $result = $qrcode->forever($token);
        $ticket = $result->ticket;
        $url = $qrcode->url($ticket);
        $content = file_get_contents($url);

        $fileName = "12345.png";
        Storage::put($fileName, $content);
        $storagePath = Storage::getDriver()->getAdapter()->getPathPrefix();
        $absolutePath = $storagePath . $fileName;
        $layer = ImageWorkshop::initFromPath($absolutePath);
        $layer->resizeInPixel(397, 397, false);
        $path2 = $storagePath . 'qrcode_background.jpg';
        $pingLayer = ImageWorkshop::initFromPath($path2);
        $pingLayer->addLayerOnTop($layer, 388, 255, 'LB');
        $pingLayer->save($storagePath, '123456.png', true, null, 95);

        $content = file_get_contents($absolutePath = $storagePath . '123456.png');

        $image = new Image();
        $image->storeImage('QrCode', $content, 'png', false);

        UserQrCode::create([
            'user_id' => $user_id,
            'image_id' => $image->id,
            'token' => $token,
        ]);
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
