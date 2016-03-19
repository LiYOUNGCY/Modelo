<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'user';

    private static $fields = ['id', 'nickname'];

    private static $user = [];

    public static function setUser($user)
    {
        if (is_object($user)) {
            foreach (self::$fields as $field) {
                if (!empty($user->$field)) {
                    self::$user[$field] = $user->$field;
                }
            }
        } elseif (is_array($user)) {
            foreach (self::$fields as $field) {
                if (!empty($user[$field])) {
                    self::$user[$field] = $user[$field];
                }
            }
        }
    }

    public static function getUser()
    {
        return self::$user;
    }
}
