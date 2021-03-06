<?php

require "../bootstrap.php";

use App\Models\Contracts\UserContract;
use App\Models\User;
use App\Utility\Hash;
use Illuminate\Database\Capsule\Manager as Capsule;

if (!Capsule::schema()->hasTable(UserContract::TABLE_NAME)) {
    Capsule::schema()
           ->create(
               UserContract::TABLE_NAME,
               function ($table)
               {
                   $table->increments(UserContract::FIELD_ID);
                   $table->string(UserContract::FIELD_USERNAME);
                   $table->string(UserContract::FIELD_PASSWORD);
                   $table->timestamps();
               }
           )
    ;

    User::create(
        [
            UserContract::FIELD_USERNAME => 'admin',
            UserContract::FIELD_PASSWORD => Hash::generate('123'),
        ]
    );
}