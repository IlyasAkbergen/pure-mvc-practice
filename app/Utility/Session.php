<?php

namespace App\Utility;

class Session
{
    public static function delete($key)
    {
        if (self::exists($key)) {
            unset($_SESSION[ $key ]);
            return true;
        }
        return false;
    }

    public static function destroy()
    {
        self::init();
        session_destroy();
    }

    public static function exists($key)
    {
        return (isset($_SESSION[ $key ]));
    }

    public static function get($key, $default = null)
    {
        if (self::exists($key)) {
            return ($_SESSION[ $key ]);
        }
        return $default;
    }

    public static function init()
    {
        // If no session exist, start the session.
        if (session_id() == "") {
            session_start();
        }
    }

    public static function put($key, $value)
    {
        self::init();
        return ($_SESSION[ $key ] = $value);
    }

}