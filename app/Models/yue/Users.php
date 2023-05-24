<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $table = 'user';
    public $timestamps = true;
    protected $fillable = ['admin','password','school_name','created_at','updated_at','email'];
    protected $primarykey = 'id';
}
