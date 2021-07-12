<?php

namespace App\Controllers;

class BaseController
{
    public function actionUndefinedRoute()
    {
        die("must be 404 page");
    }
}