<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activite extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'id_activite';
    protected $dates = ['deleted_at'];
}
