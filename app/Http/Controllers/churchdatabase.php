<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class churchdatabase extends Controller
{
    public function create_church(Request $request){
        churchdatabase::create(array(
            'database_name' => $request->database_name,
            'database_url' =>$request->url,
            'database_password' => $request->password,
            'attached_logo' =>$request->logo
        ));
        return Redirect()->back()->withErrors("church created successfully");
    }
}
