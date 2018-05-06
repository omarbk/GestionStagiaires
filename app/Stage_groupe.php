<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stage_groupe extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'id_stage_groupe';
    protected $dates = ['deleted_at'];
}
