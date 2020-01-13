<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ErrorMessagesController extends Controller
{
    public function errorResponse(){
        return redirect()->back()->withInput()->withErrors("Please input a valid phone number. Consider not using alphabetical characters");
    }
    public function get404ErrorMessage(){
        abort(404);
    }
    public function allowedContactsErrorMessage(){
        return redirect()->back()->withInput()->withErrors("The entered number is Invalid. Valid numbers
        have the syntax '25677','25678','25670','25679','25671','25675','25675',
        '25620','25639','25641'");
    }
    public function contactLengthError(){
        return redirect()->back()->withInput()->withErrors("The eneterd phone number is invalid, please input 12 valid phone number digits");
    }
    public function specialCharactersErrorResponse(){
        return redirect()->back()->withInput()->withErrors("Only digits are allowed in a phone number");
    }
    public function alphabeticalCharactersErrorResponse(){
        //return redirect()->back()->withInput()->withErrors("Phone number cannot contain Alphabetical letters");
        //return "Phone number cannot contain Alphabetical letters";
    }
}
