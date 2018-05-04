<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Groupe_stagiaire extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'id_groupe_stagiaires';
    protected $dates = ['deleted_at'];
}
