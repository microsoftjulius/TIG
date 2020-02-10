<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SendersNumber extends Model
{
    protected $table = "senders_numbers";

    protected $fillable = ["message_from","category_id"];
}
