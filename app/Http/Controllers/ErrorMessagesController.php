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
        return redirect()->back()->withInput()->withErrors("Invalid Phone number, please make sure you a valid phone numnber");
    }
    public function numberExistsError(){
        return redirect()->back()->withInput()->withErrors("Supplied number already exists");
    }
    public function emptyPhoneNumber(){
        return Redirect()->back()->withInput()->withErrors("Please Enter a phone number to continue");
    }
    public function numberDeletedSuccessfully(){
        return Redirect()->back()->withInput()->withErrors("Contact was deleted Successfully");
    }
    public function numberCreatedSuccessfully(){
        return Redirect()->back()->withErrors("Contact has been created successfully");
    }
    public function imageExtensionError(){
        return Redirect()->back()->withInput()->withErrors("The provided Logo is not valid. Please upload an image");
    }
    public function churchNameErrorResponse(){
        return Redirect()->back()->withInput()->withErrors("The supplied church name is invalid, make sure you don't use special characters");
    }
}
