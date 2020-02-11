<?php

namespace App\Imports;

use App\SendersNumber;
use Maatwebsite\Excel\Concerns\ToModel;
use Auth;
use App\category;

class SendersNumberImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if(!empty($row[0])){
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
