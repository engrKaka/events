<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected  $table ='setting';
    protected  $fillable = ['group','type','title','value','order'];
    protected $dates = ['created_at','updated_at'];
}
