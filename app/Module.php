<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Module extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'id_module';
    protected $dates = ['deleted_at'];
}
