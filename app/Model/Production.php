<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Production extends Model
{
    protected $table = 'production';

    public function color()
    {
        return $this->hasOne('App\Model\ProductionColor', 'production_id');
    }

    public function cover()
    {
        return $this->belongsTo('App\Model\Image', 'cover_id');
    }

    public function theme()
    {
        return $this->belongsTo('App\Model\Image', 'series_image');
//        return $this->belongsTo('App\Model\Image', 'theme_id');
    }

    public function get($alias)
    {
        $result = Production::where('alias', $alias)->first();
        return $result;
    }
}
