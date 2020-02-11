<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\ContactsExport;
use App\Imports\ContactsImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Groups;
use App\Contacts;

class ImportAndExportContactsController extends Controller
{
    public function __construct(){
        $this->accepted_extensions = ['xlsx','xltx'];
        $this->error_message = new ErrorMessagesController();
    }

    public function uploadExcel(){
        if(empty(request()->file('file'))){
            return redirect()->back()->withErrors("Please Attach / Upload an Excel/Csv File");
        }
        if(!in_array(strtolower(request()->file('file')->getClientOriginalExtension()), $this->accepted_extensions)){
            return $this->error_message->excelFileOrCsvFileError();
        }
        Excel::import(new ContactsImport,request()->file('file'));
        return redirect()->back()->with('message','Contacts Upload was Successfull');
    }

    public function exportContacts(){
        return Excel::download(new ContactsExport, 'contacts.xlsx');
    }
}
