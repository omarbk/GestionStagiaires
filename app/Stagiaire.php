<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stagiaire extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'id_stagiaire';
    protected $dates = ['deleted_at'];
}
