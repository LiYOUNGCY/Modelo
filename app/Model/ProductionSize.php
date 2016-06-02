<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class ProductionSize extends Model
{
    protected $table = 'production_size';

    protected $fillable = [
        'production_color_id',
        'name',
        'quantity',
    ];


    public static function get($productionId, $colorId)
    {
        $result = DB::table('production_size')
            ->join('production_color', 'production_color.id', '=', 'production_size.production_color_id')
            ->where('production_color.production_id', '=', $productionId)
            ->where('production_color.id', '=', $colorId)
            ->select(
                'production_size.id',
                'production_size.name',
                'production_size.quantity'
            )
            ->get();

        return $result;
    }
}
