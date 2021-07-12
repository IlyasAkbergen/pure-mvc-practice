<?php
namespace App;

class Router
{
    private $routes;
    private $controllerName      = 'base';
    private $actionName          = 'undefinedRoute';
    private $params              = [];
    private $controllerNamespace = 'App\Controllers';
    private $routeId             = null;

    public function __construct()
    {
        $routesPath = ROOT . '/config/routes.php';
        $this->routes = include($routesPath);
    }

    public function getController()
    {
        $controllerFileName = ucfirst($this->controllerName) . 'Controller';
        return "{$this->controllerNamespace}\\{$controllerFileName}";
    }

    public function getActionName()
    {
        return $this->actionName;
    }

    public function getParams()
    {
        return $this->params;
    }

    private function getURI ()
    {
        if (!empty($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI'], '/public/');
        }
    }

    public function parse ()
    {
        $uri = $this->getURI();

        foreach ($this->routes as $uriPattern => $item) {
            if (preg_match("/$uriPattern/", $uri)) {
                $path = $item['path'];

                if (isset($item['namespace'])) {
                    $this->controllerNamespace = $item['namespace'];
                }

                $segments = explode('/', $path);

                $this->controllerName = array_shift($segments);

                $this->actionName = array_shift($segments);

                $this->params = $segments;
            }
        }
    }


    /**
     * @return mixed
     */
    public function getRouteId()
    {
        return $this->routeId;
    }

    /**
     * @param mixed $routeId
     */
    protected function setRouteId($routeId)
    {
        $this->routeId = $routeId;
    }
}