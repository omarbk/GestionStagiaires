<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Note_type extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'id_note_type';
    protected $dates = ['deleted_at'];
}
