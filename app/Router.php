<?php
namespace App;

class Router
{
    private static $routes = [];

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
        self::$routes[ $route ] = [
            'route'      => $route,
            'controller' => $payload[ 0 ],
            'action'     => $payload[ 1 ],
            'type'       => $type,
        ];
    }

    public function route($method, $path, $params) {
        $path = "{$method} " . $this->withEscapedSlashes("/{$path}");

        foreach ($this::$routes as $pattern => $route) {
            $patternParams = $this->patternParams($pattern);
            if (!empty($patternParams)) {
                $pattern = $this->withParams($pattern);
            }
            $pattern = $this->withEscapedSlashes($pattern);
            $pattern = $this->withMethod($pattern);

            if ($this->requestMatches($pattern, $path, $patternParams, $params)) {
                $this->handle($route, $params);
                return;
            }
        }

        http_response_code(404);
        if (array_key_exists('/', $this::$routes)) {
            $this->handle($this->routes('/'));
        }
    }

    private function requestMatches($pattern, $path, $patternParams, &$params) {
        if (preg_match("/^{$pattern}$/i", $path, $matches)) {
            for ($i = 0; $i < sizeof($patternParams); $i++) {
                $params[$patternParams[$i]] = $matches[$i + 1];
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

    private function handle($route, $params)
    {
        $controller = $route['controller'];
        $action     = $route['action'];
        (new $controller)->{$action}(...$params);
    }
}