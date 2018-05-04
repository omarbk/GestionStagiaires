<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service_hospitalier extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'id_service_hospitalier';
    protected $dates = ['deleted_at'];
}
