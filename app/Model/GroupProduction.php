<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class GroupProduction extends Model
{
    protected $table = 'group_production';

    public function production()
    {
        return $this->belongsTo('App\Model\Production', 'production_id');
    }

    public static function getProductionImage($series_group_id)
    {
        $result = DB::table('group_production')
            ->join('production', 'production.id', '=', 'group_production.production_id')
            ->join('image', 'image.id', '=', 'production.series_image')
            ->where('group_production.series_group_id', '=', $series_group_id)
            ->select('production.id',
                'production.alias',
                'production.name',
                'image.path as image')
            ->get();

        return $result;
    }
}
