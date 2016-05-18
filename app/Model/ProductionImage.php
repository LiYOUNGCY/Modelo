<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class ProductionImage extends Model
{
    protected $table = 'production_image';

    public static function get($production_id, $colorAlias)
    {
        $result = DB::table('production_image')
            ->join('production_color', 'production_color.id', '=', 'production_image.production_color_id')
            ->join('image', 'image.id', '=', 'production_image.image_id')
            ->where('production_color.production_id', '=', $production_id)
            ->where('production_color.alias', '=', $colorAlias)
            ->select(
                'image.id',
                'image.path as image'
            )
            ->get();

        return $result;
    }
}
