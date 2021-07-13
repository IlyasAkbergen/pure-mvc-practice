<?php

use App\Controllers\BaseController;
use App\Controllers\TaskController;
use App\Router;

Router::get('/', 'tasks.index', [ TaskController::class, 'index' ]);
Router::get('/task/create', 'tasks.create', [ TaskController::class, 'create' ]);
Router::post('/task', 'tasks.store', [ TaskController::class, 'store' ]);
Router::get('/task/{id}', 'tasks.show', [ TaskController::class, 'show' ]);
Router::get('/task/{id}/edit', 'tasks.edit', [ TaskController::class, 'edit' ]);
Router::put('/task/{id}', 'tasks.update', [ TaskController::class, 'update' ]);

Router::get('/404', '404', [ BaseController::class, 'notFound']);