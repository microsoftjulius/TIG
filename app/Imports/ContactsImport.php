<?php

namespace App\Imports;

use App\Contacts;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Groups;

class ContactsImport implements ToModel
{
    public function __construct(){
        $this->contacts_format = ['25677','25678','25670','25679','25671','25675','25675',
        '25620','25639','25641'];
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if(!empty($row[1])){
            if(in_array(substr($row[1],0,5),$this->contacts_format)){
                if(strlen($row[1]) == 12){
                    if(Contacts::where('contact_number',$row[1])->where('group_id',request()->group_id)->where('church_id',Auth::user()->church_id)->doesntExist()){
                        $number=Groups::where('id',request()->group_id)->where('church_id',Auth::user()->church_id)->value('number_of_contacts');
                            Groups::where('id',request()->group_id)->update(array('number_of_contacts'=>$number+1));
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
            }
        }
    }
}
