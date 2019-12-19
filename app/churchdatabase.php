<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class churchdatabase extends Model
{
    protected $table = "church_databases";

    protected $fillable = ['database_name','database_url','database_password','attached_logo','church_id','church_name'];
}
