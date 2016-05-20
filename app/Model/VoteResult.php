<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class VoteResult extends Model
{
    protected $table = 'vote_result';

    public function user()
    {
        return $this->belongsTo('App\Model\User', 'user_id');
    }
}
