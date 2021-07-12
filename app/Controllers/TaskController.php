<?php

namespace App\Controllers;

use App\Template;
use App\Models\Task;

class TaskController extends BaseController
{
    public function index()
    {
        $page  = 1; // todo retrieve
        $tasks = Task::limit(3)
                     ->offset(3 * ($page - 1))
                     ->get()
        ;

        Template::view('task/index', [
            'tasks' => $tasks,
            'page'  => $page,
        ]);
    }

    public function show()
    {
        //
    }

    public function store()
    {
        // todo validate data
    }

    public function update($id)
    {
        // todo auth check and validate data
    }
}