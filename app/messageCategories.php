<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class messageCategories extends Model
{
    protected $table = "message_categories";

    protected $fillable = ['message_id','church_id'];
}
