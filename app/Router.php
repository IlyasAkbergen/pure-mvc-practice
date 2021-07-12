<?php
namespace App;

class Router
{
    private static $validRoutes = [];

    // TODO PARSE ARGUMENTS FROM URL

    public static function get(string $route, $payload)
    {
        self::set($route, $payload, 'GET');
    }

    public static function post(string $route, $payload)
    {
        self::set($route, $payload, 'POST');
    }

    public static function put(string $route, $payload)
    {
        self::set($route, $payload, 'PUT');
    }

    private static function set(string $route, array $payload, $type)
    {
        self::$validRoutes[] = [
            'route'      => $route,
            'controller' => $payload[ 0 ],
            'action'     => $payload[ 1 ],
            'type'       => $type,
        ];
    }
}