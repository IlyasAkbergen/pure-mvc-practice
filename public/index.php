<?php

use App\Dispatcher;

require "../bootstrap.php";

require_once('../routes.php');

(new Dispatcher())->dispatch();
