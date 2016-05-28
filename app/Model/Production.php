<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Production extends Model
{
    protected $table = 'production';

    public function color()
    {
        return $this->hasOne('App\Model\ProductionColor', 'production_id');
    }

    public function cover()
    {
        return $this->belongsTo('App\Model\Image', 'cover_id');
    }

    public function size_info()
    {
        return $this->belongsTo('App\Model\Image', 'size_info_id');
    }

    public function fabric_info()
    {
        return $this->belongsTo('App\Model\Image', 'fabric_info_id');
    }

    public function theme()
    {
        return $this->belongsTo('App\Model\Image', 'series_image');
    }

    public function series()
    {
        return $this->belongsTo('App\Model\Series', 'series_id');
    }

    public function get($alias)
    {
        $result = Production::where('alias', $alias)->first();
        return $result;
    }

    public static function decreaseQuantity($sid, $qty) {
        DB::table('production_size')
            ->where('id', $sid)
            ->decrement('quantity', $qty);
    }

    public static function increaseQuantity($sid, $qty) {
        ProductionSize::where('id', $sid)
            ->increment('quantity', $qty);
    }
}
