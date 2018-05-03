<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Responsable extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'id_responsable';
    protected $dates = ['deleted_at'];
}
