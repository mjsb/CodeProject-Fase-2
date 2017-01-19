<?php
/**
 * Created by PhpStorm.
 * User: marcio
 * Date: 18/01/2017
 * Time: 10:42
 */

namespace CodeProject\OAuth;

use Auth;

class Verifier
{
    public function verify($username, $password) {

        $credentials = [
            'email' => $username,
            'password' => $password,
        ];

        if(Auth::once($credentials)) {
            return Auth::user()->id;
        }

        return false;
    }

}