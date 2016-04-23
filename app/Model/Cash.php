<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Cash extends Model
{
    protected $table = 'cash';

    public function status()
    {
        return $this->belongsTo('App\Model\CashStatus', 'status_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Model\User', 'user_id');
    }
}
