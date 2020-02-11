<?php

namespace App\Imports;

use App\SendersNumber;
use Maatwebsite\Excel\Concerns\ToModel;
use Auth;

class SendersNumberImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new SendersNumber([
            'church_id'  => Auth::user()->church_id,
            'user_id'    => Auth::user()->id,
            'contact'    => $row['0'],
            'category_id' => request()->category
        ]);
    }
}
