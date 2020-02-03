<?php

namespace App\Exports;

use App\Contacts;
use Maatwebsite\Excel\Concerns\FromCollection;

class ContactsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Contacts::where('group_id',request()->group_id)->get();
    }
}
