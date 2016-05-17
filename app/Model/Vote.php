<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $table = 'vote';

    protected $fillable = [
        'A',
        'B',
        'C',
        'D',
        'E',
    ];
}
