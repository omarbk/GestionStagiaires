<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Evaluation_objectif extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'id_evaluation_objectif';
    protected $dates = ['deleted_at'];
}
