<?php

namespace App\Models;

use App\Models\Contracts\UserContract;
use Illuminate\Database\Eloquent\Model;

class User extends Model implements UserContract
{
    protected $hidden = [ self::FIELD_PASSWORD ];
}