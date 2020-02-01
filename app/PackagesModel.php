<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PackagesModel extends Model
{
    protected $table = "packages";

    protected $fillable = ['church_id','time_frame','package_name','contact_number','Amount','type'];
}
