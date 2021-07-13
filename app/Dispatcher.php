<?php

namespace App;

use Illuminate\Database\RecordsNotFoundException;

class Dispatcher {
    private Router $router;

    function __construct() {
        $this->router = new Router();
    }

    function dispatch() {
        try {
            $this->router->route(
                $_SERVER[ 'REQUEST_METHOD' ],
                parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH),
                $_REQUEST
            );
        } catch (RecordsNotFoundException $e) {
            $this->router->redirect('404');
        }
    }
}