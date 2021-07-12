<?php

namespace App\Models\Contracts;

interface UserContract
{
    const TABLE_NAME = 'users';

    const FIELD_ID       = 'id';
    const FIELD_USERNAME = 'username';
    const FIELD_PASSWORD = 'password';

    const FIELD_CREATED_AT = 'created_at';
    const FIELD_UPDATED_AT = 'updated_at';
}