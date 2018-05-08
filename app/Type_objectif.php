<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Type_objectif extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'id_type';
    protected $dates = ['deleted_at'];
}
