<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PackagesModel extends Model
{
    protected $table = "packages";

    protected $fillable = ['church_id','category_id','time_frame','contact_number','Amount','type'];
}
