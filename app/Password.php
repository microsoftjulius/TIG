<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Password extends Model
{
    //
    protected $table = "changed_passwords";
    protected $fillable = ['current_password','new_password','confirm_password'];
}
