<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
//use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Config;


class Controller extends BaseController
{
    use DispatchesJobs, ValidatesRequests;

    protected static $RULES;
    public function __construct()
    {
        if(empty(self::$RULES)) {
            self::$RULES = Config::get('validate');
        }
    }

    public function myValidate(Request $request, $field)
    {
        $rules = [];
        foreach($field as $rule) {
            if(isset(self::$RULES[$rule])) {
                $rules[$rule] = self::$RULES[$rule];
            }
        }
        $this->validate($request, $rules);
    }
}
