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
            'group_id'          =>  request()->group_id,
            'created_by'        =>  Auth::user()->id,
            'update_by'         =>  Auth::user()->id,
            'contact_number'    =>  $row['1'],
            'u_name'            =>  $row['0']
        ]);
    }
}
