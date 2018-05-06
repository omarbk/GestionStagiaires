<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stage extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'id_stage';
    protected $dates = ['deleted_at'];
}
