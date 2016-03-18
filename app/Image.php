<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Image extends Model
{
    protected $table = 'image';

    protected static $limit = 20;

    /**
     * @param int $page
     * @return mixed
     * @throws \Exception
     */
    public static function getAll($page = 1)
    {
        if ($page < 1) {
            throw new \Exception();
        }
        $data = DB::table('image')
            ->select('*')
            ->skip(($page - 1) * self::$limit)
            ->take(self::$limit)
            ->get();

        return $data;
    }

    public static function getAllPage()
    {
        $count = DB::table('image')->count();
        return ceil($count / self::$limit);
    }

    public static function get($id)
    {
        $data = DB::table('image')
            ->where('image.id', '=', $id)
            ->select('*')
            ->first();

        return $data;
    }
}
