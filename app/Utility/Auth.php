<?php

namespace App\Utility;

use App\Models\User;

class Auth
{
    public static function isAuthenticated(): bool
    {
        Session::init();
        return Session::exists('user');
    }

    public static function user(): ?User
    {
        Session::init();
        $user_id = Session::get('user');
        return $user_id
            ? User::find($user_id)
            : null
        ;
    }
}