<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SendersNumber extends Model
{
    protected $table = "senders_numbers";

    protected $fillable = ["contact","category_id","church_id","package_id"];
}
