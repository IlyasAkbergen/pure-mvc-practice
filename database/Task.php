<?php

require "../bootstrap.php";

use App\Models\Task;
use Illuminate\Database\Capsule\Manager as Capsule;

if (!Capsule::schema()->hasTable(Task::TABLE_NAME)) {
    Capsule::schema()
           ->create(
               Task::TABLE_NAME,
               function ($table)
               {
                   $table->increments(Task::FIELD_ID);
                   $table->string(Task::FIELD_USERNAME);
                   $table->string(Task::FIELD_EMAIL);
                   $table->string(Task::FIELD_TEXT);
                   $table->timestamps();
               }
           )
    ;
}
