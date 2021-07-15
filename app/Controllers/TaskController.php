<?php

namespace App\Controllers;

use App\Models\Task;
use App\Router;
use Rakit\Validation\Validator;

class TaskController extends BaseController
{
    public function index()
    {
        $per_page    = 3;
        $page        = $this->requestParams->get('page', 1);

        $tasks_count = Task::count();
        $all_pages   = $tasks_count
            ? ceil($tasks_count / $per_page)
            : 0;

        $sort_field  = $this
            ->requestParams
            ->get('sort_field');

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

        $this->view('task/index', [
            'tasks'       => $tasks,
            'page'        => $page,
            'all_pages'   => $all_pages,
            'sort_field'  => $sort_field,
            'sort_fields' => Task::SORT_FIELDS,
        ]);
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
        $input = $this->requestParams
            ->only(
                [
                    Task::FIELD_USERNAME,
                    Task::FIELD_TEXT,
                    Task::FIELD_EMAIL,
                ]
            )
            ->toArray()
        ;

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
        if (false) {
            return Router::redirect('tasks.index');
        }

        $task = Task::findOrFail($id);

        $this->view('task/edit', [
           'task'   => $task->toArray(),
        ]);
    }
    
    public function update($id)
    {
        $input = $this->requestParams
            ->only(Task::FILLABLE)
            ->toArray()
        ;

        $validation = (new Validator())
            ->make(
                $input,
                [
                    'username' => 'required|max:255',
                    'email'    => 'required|email',
                    'text'     => 'required|max:255',
                    'is_done'  => 'required|boolean',
                ]
            );

        $validation->validate();

        if ($validation->fails()) {
            $errors = $validation->errors();
            $input['id'] = $id;
            $this->view(
                'task/edit',
                [
                    'task'   => $input,
                    'errors' => $errors,
                ]
            );
            return;
        }

        $task = Task::findOrFail($id);

        $task->update($input);

        $this->view('task/show', compact('task'));
    }
}