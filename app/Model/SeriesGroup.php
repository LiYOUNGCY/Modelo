<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SeriesGroup extends Model
{
    protected $table = 'series_group';

    public function image()
    {
        return $this->belongsTo('App\Model\Image', 'image_id');
    }
}
