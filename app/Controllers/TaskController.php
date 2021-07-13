<?php

namespace App\Controllers;

use App\Template;
use App\Models\Task;

class TaskController extends BaseController
{
    public function index()
    {
        $page = $this->requestParams->get('page', 1);

        $tasks = Task::limit(3)
                     ->offset(3 * ($page - 1))
                     ->get()
        ;

        Template::view('task/index', [
            'tasks' => $tasks,
            'page'  => $page,
        ]);
    }

    public function create()
    {
        
    }
    
    public function show($id)
    {
        $task = Task::findOrFail($id);

        Template::view('task/show', [
            'task' => $task,
        ]);
    }
    
    public function store()
    {
        //
    }
    
    public function edit($id)
    {
        $task = Task::findOrFail($id);

        Template::view('task/edit', [
           'task' => $task,
        ]);
    }
    
    public function update($id)
    {
        // todo auth check and validate data
    }
}