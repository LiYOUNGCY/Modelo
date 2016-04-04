<?php

namespace App\Container;

use App;

/**
 * Class Container
 * @package App\Container
 * the container for application
 * store global variable
 */
class Container
{
    /**
     * @param $userId
     */
    public static function setUser($userId)
    {
        App::singleton('user', function() use($userId) {
            return App\Model\User::find($userId);
        });
    }

    /**
     * @return App\Model\User
     */
    public static function getUser()
    {
        return App::make('user');
    }
}