<?php

namespace App;

class Dispatcher {
    private Router $router;

    function __construct() {
        $this->router = new Router();
    }

    function dispatch() {
        $this->router->route(
            $_SERVER['REQUEST_METHOD'],
            $_SERVER['REQUEST_URI'],
            $_REQUEST
        );
    }
}