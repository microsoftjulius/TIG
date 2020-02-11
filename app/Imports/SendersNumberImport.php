<?php

namespace App\Imports;

use App\SendersNumber;
use Maatwebsite\Excel\Concerns\ToModel;
use Auth;
use App\category;

class SendersNumberImport implements ToModel
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
        if(!empty($row[0])){
                if(in_array(substr($row[0],0,5),$this->contacts_format)){
                    if(strlen($row[0]) == 12){
                        if(SendersNumber::where('contact',$row[0])->where('church_id',Auth::user()->church_id)->doesntExist()){
                            $number=category::where('id',request()->category)->where('church_id',Auth::user()->church_id)->value('number_of_subscribers');
                            category::where('id',request()->category)->update(array('number_of_subscribers'=>$number+1));
                            return new SendersNumber([
                                'church_id'  => Auth::user()->church_id,
                                'user_id'    => Auth::user()->id,
                                'contact'    => $row['0'],
                                'category_id' => request()->category
                            ]);
                        }
                }
            }
        }
    }
}
