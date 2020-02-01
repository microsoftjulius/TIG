<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    protected $table ="category";
    protected $fillable = ['user_id','church_id','category','title','number_of_subscribers'];
}
