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

    public static function decreaseQuantity($sid, $qty) {
        DB::table('production_size')
            ->where('id', $sid)
            ->decrement('quantity', $qty);
    }

    public static function increaseQuantity($sid, $qty) {
        ProductionSize::where('id', $sid)
            ->increment('quantity', $qty);
    }

    public static function get($categoryId = 0)
    {
        $result = [];

        if(isset($categoryId) && is_numeric($categoryId) && $categoryId != 0) {
            $result = DB::table('production')
                ->join('image', 'image.id', '=', 'production.cover_id')
                ->join('production_category', 'production_category.production_id', '=', 'production.id')
                ->where('production_category.category_id', $categoryId)
                ->select(
                    'production.id',
                    'production.name',
                    'image.path as cover'
                )
                ->get();
        } else {
            $result = DB::table('production')
                ->join('image', 'image.id', '=', 'production.cover_id')
                ->select(
                    'production.id',
                    'production.name',
                    'image.path as cover'
                )
                ->get();
        }

        return $result;
    }
}
