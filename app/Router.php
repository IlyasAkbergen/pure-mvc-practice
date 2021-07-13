<?php
namespace App;

use Illuminate\Database\RecordsNotFoundException;

class Router
{
    private static $routes = [];
    const HOME_PATH_NAME = 'tasks.index';

    public static function get(string $path, string $name, $payload)
    {
        self::set($path, $name, $payload, 'GET');
    }

    public static function post(string $path, string $name, $payload)
    {
        self::set($path, $name, $payload, 'POST');
    }

    public static function put(string $path, string $name, $payload)
    {
        self::set($path, $name, $payload, 'PUT');
    }

    private static function set(string $path, string $name, array $payload, $type)
    {
        self::$routes[ $name ] = [
            'path'       => $path,
            'controller' => $payload[ 0 ],
            'action'     => $payload[ 1 ],
            'type'       => $type,
        ];
    }

    public function route($method, $path, $params) {
        $path = "{$method} " . $this->withEscapedSlashes("{$path}");

        foreach ($this::$routes as $route) {
            $pattern = $route[ 'path' ];
            $patternParams = $this->patternParams($pattern);

            if (!empty($patternParams)) {
                $pattern = $this->withParams($pattern);
            }
            $pattern = $this->withEscapedSlashes($pattern);
            $pattern = $this->withMethod($pattern);
            $args = [];
            $match = $this->requestMatches($pattern, $path, $patternParams, $args);

            if ($match) {
                $this->handle($route, $args, $params);
                return;
            }
        }

        http_response_code(404);
        if (array_key_exists(self::HOME_PATH_NAME, $this::$routes)) {
            $this->handle($this::$routes[self::HOME_PATH_NAME]);
        }
    }

    private function requestMatches($pattern, $path, $patternParams, &$params) {
        if (preg_match("/^{$pattern}$/i", $path, $matches)) {
            if ($patternParams) {
                for ($i = 0; $i < sizeof($patternParams); $i++) {
                    $params[ $patternParams[ $i ] ] = $matches[ $i + 1 ];
                }
            }
            return true;
        }
        return false;
    }

    private function patternParams($pattern) {
        $matches = [];
        if (preg_match_all('/{(\w+)}/', $pattern, $matches)) {
            return $matches[1];
        }
    }

    private function withEscapedSlashes($pattern) {
        return str_replace('/', ':', $pattern);
    }

    private function withMethod($pattern) {
        return !preg_match("/^[A-Z]+ .+$/i", $pattern) ? "GET {$pattern}" : $pattern;
    }

    private function withParams($pattern) {
        return preg_replace('/{\w+}/', '([^:]+)', $pattern);
    }

    public function handle($route, $args = [], $params = [])
    {
        $controller = $route['controller'];
        $action     = $route['action'];
        (new $controller)->__callAction($action, $args, $params);
    }

    public function redirect($route_name)
    {
        try {
            $route = self::$routes[$route_name];
            $this->handle($route);
        } catch (\Exception $e) {
            throw new RecordsNotFoundException();
        }
    }
}