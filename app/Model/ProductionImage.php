<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class ProductionImage extends Model
{
    protected $table = 'production_image';

    protected $fillable = [
        'production_color_id',
        'image_id',
    ];

    public static function get($productionId, $colorId)
    {
        $result = DB::table('production_image')
            ->join('production_color', 'production_color.id', '=', 'production_image.production_color_id')
            ->join('image', 'image.id', '=', 'production_image.image_id')
            ->where('production_color.production_id', '=', $productionId)
            ->where('production_color.id', '=', $colorId)
            ->select(
                'image.id',
                'image.path as image'
            )
            ->get();

        return $result;
    }
}
