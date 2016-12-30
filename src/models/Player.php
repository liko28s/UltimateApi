<?php

namespace Nextria\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Player extends Model {
    use SoftDeletes;
    protected $dates = ['deleted_at'];
}