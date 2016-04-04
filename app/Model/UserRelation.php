<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserRelation extends Model
{
    protected $table = 'user_relation';

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

    public function insert($childrenId, $parentId)
    {
        $this->children_id = $childrenId;
        $this->parent_id = $parentId;
        $this->save();
    }
}
