<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class ProductionColor extends Model
{
    protected $table = 'production_color';

    public function image()
    {
        return $this->belongsTo('App\Model\Image', 'image_id');
    }

    public static function get($production_id)
    {
        $result = ProductionColor::where('production_id', $production_id)
            ->get();

        return $result;
    }
}
