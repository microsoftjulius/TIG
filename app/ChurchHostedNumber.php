<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChurchHostedNumber extends Model
{
    protected $table = "ChurchHostedNumber";
    protected $fillable = ['contact_number','church_id'];
}
