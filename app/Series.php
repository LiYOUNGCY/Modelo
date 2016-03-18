<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Series extends Model
{
    protected $table = 'series';

    protected static $limit = 20;

    public static function getAll($page = 1)
    {
        if ($page < 1) {
            throw new \Exception();
        }
        $data = DB::table('series')
            ->select('*')
            ->skip(($page - 1) * self::$limit)
            ->take(self::$limit)
            ->get();

        return $data;
    }

    public static function getAllPage()
    {
        $count = DB::table('series')->count();
        return ceil($count / self::$limit);
    }
}
