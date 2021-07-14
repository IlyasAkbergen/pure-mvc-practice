<?php

namespace App\Controllers;

use App\Models\Task;
use App\Router;
use Rakit\Validation\Validator;

class TaskController extends BaseController
{
    public function index()
    {
        $per_page = 3;
        $page = $this->requestParams->get('page', 1);
        $sort_field = $this
            ->requestParams
            ->get('sort_field')
        ;

        $sort_field = in_array($sort_field, Task::SORT_FIELDS)
            ? $sort_field
            : null;

        $tasks = Task::limit($per_page)
                     ->offset($per_page * ($page - 1))
                     ->when($sort_field, function ($q) use ($sort_field) {
                         $q->orderBy($sort_field);
                     })
                     ->get()
        ;

        $this->view('task/index', compact('tasks', 'page'));
    }

    public function create()
    {
        $this->view('task/create');
    }
    
    public function show($id)
    {
        $task = Task::findOrFail($id);

        $this->view('task/show', compact('task'));
    }
    
    public function store()
    {
        $input = $this->requestParams->only(Task::FILLABLE)->toArray();

        $validation = (new Validator())
            ->make(
                $input,
                [
                    'username' => 'required|max:255',
                    'email'    => 'required|email',
                    'text'     => 'required|max:255',
                ]
            );

        $validation->validate();

        if ($validation->fails()) {
            $errors = $validation->errors();
            $this->view(
                'task/create',
                [
                    'input'  => $input,
                    'errors' => $errors,
                ]
            );
            return;
        }

        $task = Task::create($input);

       $this->view('task/show', compact('task'));
    }
    
    public function edit($id)
    {
        // todo check auth
        if (true) {
            return Router::redirect('tasks.index');
        }
        $task = Task::findOrFail($id);

        $this->view('task/edit', [
           'task' => $task,
        ]);
    }
    
    public function update($id)
    {
        // todo auth check and validate data
        // todo redirect to show
    }
}