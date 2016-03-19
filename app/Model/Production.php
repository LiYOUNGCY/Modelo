<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Production extends Model
{
    protected $table = 'production';

    public static function getById($id)
    {
        $data = DB::table('production')
            ->join('production_color', 'production.id', '=', 'production_color.production_id')
//            ->join('production_size', 'production_color.id', '=', 'production_size.production_color_id')
//            ->join('production_image', 'production_color.id', '=', 'production_image.production_color_id')
            ->where('production.id', '=', $id)
            ->select('*', 'production_color.id as cid')
            ->first();

        $data->size = DB::table('production_size')
            ->join('production_color', 'production_size.production_color_id', '=', 'production_color.id')
            ->join('production', 'production.id', '=', 'production_color.production_id')
            ->select('*')
            ->get();


        return $data;
    }

    public static function getAll()
    {
        $data = DB::table('production')
            ->join('series', 'series.id', '=', 'production.series_id')
            ->leftjoin('image', 'image.id', '=', 'production.cover_id')
            ->select(
                'production.id',
                'production.name',
                'production.alias',
                'series.name as series',
                'image.path as cover'
            )
            ->get();

        return $data;
    }

    public static function getProductionByAlias($alias)
    {
        $data = DB::table('production')
            ->join('series', 'series.id', '=', 'production.series_id')
            ->leftJoin('image', 'image.id', '=', 'production.cover_id')
            ->where('production.alias', '=', $alias)
            ->select(
                'production.id',
                'production.name',
                'production.alias',
                'series.id as series_id',
                'series.name as series',
                'image.path as cover',
                'image.name as cover_name',
                'production.cover_id'
            )
            ->first();

        return $data;
    }

    public static function getProductionColorByAlias($alias)
    {
        $data = DB::table('production')
            ->join('production_color', 'production.id', '=', 'production_color.production_id')
            ->where('production.alias', '=', $alias)
            ->select(
                'production_color.id',
                'production_color.name',
                'production_color.price',
                'production_color.alias'
            )
            ->get();

        return $data;
    }

    public static function getProductionSize($color_id)
    {
        $query = DB::table('production_size')
            ->join('production_color', 'production_color.id', '=', 'production_size.production_color_id')
            ->where('production_color.id', '=', $color_id)
            ->select(
                'production_size.id',
                'production_size.name',
                'production_size.quantity'
            )
            ->get();
        return $query;
    }

    public static function getProduction($color_id)
    {
        $data = [];

        $data['size'] = DB::table('production_size')
            ->join('production_color', 'production_color.id', '=', 'production_size.production_color_id')
            ->where('production_color.id', '=', $color_id)
            ->select(
                'production_size.id',
                'production_size.name',
                'production_size.quantity'
            )
            ->get();

        $data['image'] = DB::table('production_image')
            ->join('production_color', 'production_color.id', '=', 'production_image.production_color_id')
            ->join('image', 'production_image.image_id', '=', 'image.id')
            ->where('production_color.id', '=', $color_id)
            ->where('production_image.primary', '=', 1)
            ->orderBy('production_image.id', 'desc')
            ->select(
                'production_image.id',
                'production_image.image_id',
                'image.path as image',
                'image.name'
            )
            ->get();

        return $data;
    }

    public static function get($production_alias, $color_alias, $size_id, $qty)
    {
        $query = DB::table('production')
            ->where('production.alias', '=', $production_alias)
            ->join('production_color', 'production_color.production_id', '=', 'production.id')
            ->where('production_color.alias', '=', $color_alias)
            ->join('production_size', 'production_size.production_color_id', '=', 'production_color.id')
            ->where('production_size.id', '=', $size_id)
            ->where('production_size.quantity', '>=', $qty)
            ->join('image', 'image.id', '=', 'production.cover_id')
            ->select(
                'production.id',
                'production.name',
                'production.alias',
                'image.path as cover',
                'production_color.price',
                'production_color.id as color_id',
                'production_color.name as color_name',
                'production_size.id as size_id',
                'production_size.name as size_name'
            )
            ->first();

        return $query;
    }
}
