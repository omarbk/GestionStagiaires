<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Calendrier extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'id_calendrier';
    protected $dates = ['deleted_at'];
}
