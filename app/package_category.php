<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class package_category extends Model
{
    protected $table = "package_category";
    protected $fillable = ['package_id','category_id','church_id']; 
}
