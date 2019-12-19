<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class searchTerms extends Model
{
    protected $table = "search_terms";

    protected $fillable = ['user_id','church_id','search_term','category_id'];
}
