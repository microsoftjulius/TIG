<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class church_user extends Model
{
    //
    protected $fillable =['id','first_name','last_name','username','password','church_id'];
}
