<?php

namespace App\Utility;

class Hash
{
    public static function generate($string)
    {
        return (hash("sha256", $string));
    }
}
