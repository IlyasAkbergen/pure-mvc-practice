<?php

use App\Controllers\AuthController;
use App\Controllers\BaseController;
use App\Controllers\TaskController;
use App\Router;

Router::get('/', 'tasks.index', [ TaskController::class, 'index' ]);
Router::get('/task/create', 'tasks.create', [ TaskController::class, 'create' ]);
Router::post('/task', 'tasks.store', [ TaskController::class, 'store' ]);
Router::get('/task/{id}', 'tasks.show', [ TaskController::class, 'show' ]);
Router::get('/task/{id}/edit', 'tasks.edit', [ TaskController::class, 'edit' ]);
Router::post('/task/{id}/update', 'tasks.update', [ TaskController::class, 'update' ]);

Router::get('/login', 'login',  [ AuthController::class, 'login' ]);
Router::post('/authenticate', 'auth',  [ AuthController::class, 'authenticate' ]);
Router::get('/logout', 'logout',  [ AuthController::class, 'logout' ]);

Router::get('/404', '404', [ BaseController::class, 'notFound']);
