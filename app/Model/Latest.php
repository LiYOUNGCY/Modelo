<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;


class Latest extends Model
{
    protected $table = 'latest';

    public static function destroyAll()
    {
        DB::table('latest')->delete();
    }

    public static function getRows()
    {
        $result = DB::table('latest')
            ->select('row')
            ->groupBy('row')
            ->get();

        return $result;
    }

    public static function get()
    {
        $result = [];

        $rows = self::getRows();

        foreach ($rows as $row) {
            $result[$row->row] = DB::table('latest')
                ->where('latest.row', '=', $row->row)
                ->get();
        }

        return $result;
    }
}
