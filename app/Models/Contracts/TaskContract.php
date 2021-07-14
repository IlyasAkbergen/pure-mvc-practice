<?php

namespace App\Models\Contracts;

use App\Models\Task;

interface TaskContract
{
    const TABLE_NAME = 'tasks';

    const FIELD_ID       = 'id';
    const FIELD_USERNAME = 'username';
    const FIELD_EMAIL    = 'email';
    const FIELD_TEXT     = 'text';

    const FIELD_CREATED_AT = 'created_at';
    const FIELD_UPDATED_AT = 'updated_at';

    const SORT_FIELDS = [
        self::FIELD_ID,
        self::FIELD_USERNAME,
        self::FIELD_TEXT,
        self::FIELD_EMAIL,
    ];
}