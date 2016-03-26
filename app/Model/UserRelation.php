<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserRelation extends Model
{
    protected $table = 'user_relation';

    public static function belongTo($user_id, $token)
    {
        DB::insert("INSERT INTO user_relation(parent_id, children_id) SELECT user_qrcode.user_id, ? FROM user_qrcode WHERE user_qrcode.token = ?", [$user_id, $token]);
    }

    public static function hasParent($user_id)
    {
        $count = DB::table('user_relation')
            ->where('user_relation.children_id', '=', $user_id)
            ->count();
        return $count === 1;
    }

    public static function getParent($user_id)
    {
        $data = DB::table('user_relation')
            ->where('user_relation.children_id', '=', $user_id)
            ->select(
                'user_relation.id',
                'user_relation.parent_id as parent'
            )
            ->first();
        return $data;
    }
}
