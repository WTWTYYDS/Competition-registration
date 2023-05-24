<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class managers extends Model
{
    protected $table = 'manager';
    public $timestamps = true;
    protected $fillable = ['school_name','name','sex','age','nation','phone','identity','state',
        'competition_group','education','teacher','competition_1','competition_2','competition_3'];
    protected $primarykey = 'id';
}
