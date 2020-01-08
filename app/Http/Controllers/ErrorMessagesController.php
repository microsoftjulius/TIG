<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ErrorMessagesController extends Controller
{
    public function errorResponse(){
        return redirect()->back()->withInput()->withErrors("Please input a phone number as a user name, Required phone numbers have a format 256*********");
    }
}
