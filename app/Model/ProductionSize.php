<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class ProductionSize extends Model
{
    protected $table = 'production_size';


    public static function get($production_id, $colorAlias)
    {
        $result = DB::table('production_size')
            ->join('production_color', 'production_color.id', '=', 'production_size.production_color_id')
            ->where('production_color.production_id', '=', $production_id)
            ->where('production_color.alias', '=', $colorAlias)
            ->select(
                'production_size.id',
                'production_size.name',
                'production_size.quantity'
            )
            ->get();

        return $result;
    }
}
