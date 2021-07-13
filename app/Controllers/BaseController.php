<?php

namespace App\Controllers;

use App\Template;
use Illuminate\Support\Collection;

class BaseController
{
    /**
     * @var Collection $requestParams
    */
    protected $requestParams;

    public function __callAction($action, $args = [], $params = [])
    {
        $this->requestParams = new Collection($params);
        return call_user_func_array([$this, $action], $args);
    }

    public function notFound()
    {
        Template::view('404');
    }
}