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
}
