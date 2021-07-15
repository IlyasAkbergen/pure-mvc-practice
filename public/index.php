<?php

require "../bootstrap.php";

use App\Dispatcher;

require_once('../routes.php');

(new Dispatcher())->dispatch();
