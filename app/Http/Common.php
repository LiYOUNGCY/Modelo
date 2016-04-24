<?php

namespace App\Http;

use App\Container\Container;
use App\Model\AuthToken;
use App\Model\User;
use Config;
use Hash;
use Cookie;

class Common
{
    public static function createLoginCookie()
    {
        $user = Container::getUser();

        $selector = str_random(12);
        $token = str_random(64);

        //validator = hash(token)
        $validator = Hash::make($token);

        $expires = Config::get('constants.cookieTime');

        //store the validator in database
        $auth_token = new AuthToken();
        $auth_token->selector = $selector;
        $auth_token->token = $token;
        $auth_token->user_id = $user['id'];
        $auth_token->expires = time() + $expires * 60;
        $auth_token->save();

        $cookieName = Config::get('constants.rememberCookie');
        $cookieValue = $selector . $validator;

        Cookie::queue($cookieName, $cookieValue, $expires);
    }

    public static function checkLoginCookie()
    {
        $cookieName = Config::get('constants.rememberCookie');
        $cookie = Cookie::get($cookieName);
        $expires = Config::get('constants.cookieTime');

        $selector = substr($cookie, 0, 12);
        $validator = substr($cookie, 12);

        $auth_token = AuthToken::where('selector', $selector)->first();


        if (isset($auth_token)
            && isset($cookie)
            && Hash::check($auth_token->token, $validator)
            && time() <= $auth_token->expires
        ) {
            //refresh cookie expires
            $auth_token->expires = time() + $expires * 60;
            $auth_token->save();

            //cookie is validated && get the user information
            $user = User::where('id', $auth_token->user_id)->first();
            Container::setUser($user->id);

            Cookie::queue($cookieName, $cookie, $expires);

            return true;
        }

        return false;
    }
}
