<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Total_note extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'id_total_note';
    protected $dates = ['deleted_at'];
}
