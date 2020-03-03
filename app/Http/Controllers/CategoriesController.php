<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SendersNumber;
use Auth;
use App\category;

class CategoriesController extends Controller
{
    public function __construct(Request $request){
        $this->error_message = new ErrorMessagesController();
        $this->contacts_format = ['25677','25678','25670','25679','25671','25675','25675',
        '25620','25639','25641'];
        $this->contact_length = 12;
        $this->contact_number = request()->contact_number;
    }

    public function addContacts(){
        return view('after_login.add_contacts_to_category');
    }

    protected function saveContactToCategory($id){
        if(SendersNumber::where(''))
        $contact = new SendersNumber();
        $contact->contact = $this->contact_number;
        $contact->category_id = $id;
        $contact->church_id   = Auth::user()->church_id;
        $contact->save();

        $number = category::where('id',$id)->value('number_of_subscribers');
        category::where('id',$id)->update(array('number_of_subscribers' => $number+1));
        return redirect()->back()->with('message','Contact Added Successfully');
    }
    
    public function saveContact($id){
        if(SendersNumber::where('contact',$this->contact_number)->where('church_id',Auth::user()->church_id)->exists()){
            return $this->error_message->numberExistsError();
        }
        if(empty($this->contact_number)) {
            return $this->error_message->emptyPhoneNumber();
        }
        if(!in_array(substr($this->contact_number,0,5),$this->contacts_format)){
            return $this->error_message->allowedContactsErrorMessage();
        }
        if(strlen($this->contact_number) > $this->contact_length || strlen($this->contact_number) < $this->contact_length){
            return $this->error_message->contactLengthError();
        }
        if(!ctype_digit($this->contact_number)){
            return $this->error_message->alphabeticalCharactersErrorResponse();
        }
        else{
            return $this->saveContactToCategory($id);
        }
    }
}
