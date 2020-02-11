<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\SendersNumberImport;
use Maatwebsite\Excel\Facades\Excel;
use App\SendersNumber;
use App\category;

class ImportCategoriesContacts extends Controller
{
    public function import($id) 
    {
        Excel::import(new SendersNumberImport,request()->file('file'));
        $number = category::where('id',$id)->value('number_of_subscribers');
        category::where('id',$id)->update(array('number_of_subscribers'=>$number+1));
        return redirect()->back()->with('message',"Contacts upload was successful");
    }
}
