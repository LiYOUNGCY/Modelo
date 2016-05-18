<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Series extends Model
{
    protected $table = 'series';


    public static function getAll()
    {
        $data = DB::table('series')
            ->select('*')
            ->get();

        return $data;
    }
}
