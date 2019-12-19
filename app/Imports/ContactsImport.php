<?php

namespace App\Imports;

use App\Contacts;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;

class ContactsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Contacts([
            'church_id'         =>  Auth::user()->church_id,
            'group_id'          =>  2,
            'created_by'        =>  Auth::user()->id,
            'update_by'         =>  Auth::user()->id,
            'contact_number'    =>  $row['2'],
        ]);
    }
}
