<?php

use App\Controllers\TaskController;
use App\Router;

Router::get('/', [ TaskController::class, 'index' ]);
Router::post('/task', [ TaskController::class, 'store' ]);
Router::put('/task', [ TaskController::class, 'store' ]);