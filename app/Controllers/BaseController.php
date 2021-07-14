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
        $this->requestParams = (new Collection($params))
            ->map(function ($item) {
                return trim($item, "`\"'/\|{};:");
            })
        ;
        return call_user_func_array([$this, $action], $args);
    }

    public function view($path, $data = [])
    {
        Template::view($path, $data);
    }

    public function notFound()
    {
        $this->view('404');
    }
}