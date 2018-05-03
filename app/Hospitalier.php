<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hospitalier extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'id_hospitalier';
    protected $dates = ['deleted_at'];
}
