<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Groups extends Model
{
    protected $table = "Groups";
    protected $fillable = ['group_name','church_id','created_by','number_of_contacts'];
}
