<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PermisionsController extends Controller
{
    public function rolesAndPermisionsView(){
        return view('after_login.permisions');
    }
}
