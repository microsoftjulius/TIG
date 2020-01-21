<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactsVerificationController extends Controller
{
    public function __construct(Request $request){
        $this->phone_number = $request->hosted_number;
    }
    
    public function checkIfContactIsValid(){
        if(empty($this->phone_number)) {
            return $this->error_message->emptyPhoneNumber();
        }
        if(strlen($this->phone_number) > $this->contact_length || strlen($this->phone_number) < $this->contact_length){
            return $this->error_message->contactLengthError();
        }
        if(!ctype_digit($this->phone_number)){
            return $this->error_message->alphabeticalCharactersErrorResponse();
        }
        if(!in_array(substr($this->phone_number,0,5),$this->contacts_format)){
            return $this->error_message->allowedContactsErrorMessage();
        }
    }
}
