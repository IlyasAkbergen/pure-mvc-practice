<?php

namespace App\Controllers;

use App\Core\Template;
use App\Models\Task;

class TaskController extends BaseController
{
    public function index()
    {
        Template::view('task/index', []);
    }

    public function show($id)
    {
        die('12312');
    }
}