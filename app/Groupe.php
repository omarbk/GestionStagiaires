<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Groupe extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'id_groupe';
    protected $dates = ['deleted_at'];
}
