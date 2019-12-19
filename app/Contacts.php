<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contacts extends Model
{
    protected $fillable = ['church_id','group_id','created_by','update_by','contact_number'];
}
