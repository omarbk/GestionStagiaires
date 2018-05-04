<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Evaluateur extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'id_evaluateur';
    protected $dates = ['deleted_at'];
}
