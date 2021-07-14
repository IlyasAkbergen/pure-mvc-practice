<?php

namespace App\Models;

use App\Models\Contracts\TaskContract;
use Illuminate\Database\Eloquent\Model;

class Task extends Model implements TaskContract
{
    protected $fillable = self::FILLABLE;
}