<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class messages extends Model
{
    protected $fillable =['group_id','message','tobesent_on','church_id','created_by','status','category_id'];
}
