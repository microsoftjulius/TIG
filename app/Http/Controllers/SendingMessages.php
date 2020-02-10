<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\messages;
use App\Contacts;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Groups;

class SendingMessages extends Controller
{
    /**
     * The contact_number field is the hosted number litrary
     */
    public function __construct(Request $request){
        $this->error_message    = new ErrorMessagesController();
        $this->api_response     = new APIResponseMessage();
        $this->message          = request()->message;
        $this->groups_array     = request()->checkbox;
        $this->empty_array      = [];
        $this->valid_array      = [];
    }



    public function sendImmediateMessage(Request $request) {
        if(!empty(request()->scheduled_date)){
            return $this->api_response->saveGroupsSentMessage();
        }
            $this->api_response->getValidAndEmptyGroups();
            $msgData_array = [];
            foreach($this->api_response->getValidArray() as $contacts){
                if(in_array(array('number' => $contacts, 'message' => $this->message, 'senderid' => 'Good'), $msgData_array)){
                    continue;
                }else{
                    array_push($msgData_array, array('number' => $contacts, 'message' => $this->message, 'senderid' => 'Good'));
                }
            }
            $data = array('method' => 'SendSms', 'userdata' => array('username' => 'microsoft','password' => '123456'),'msgdata' => $msgData_array);
            $json_builder = json_encode($data);
            $ch = curl_init('http://www.egosms.co/api/v1/json/');
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json_builder); 
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $ch_result = curl_exec($ch);
            curl_close($ch);

            $this->api_response->saveGroupsSentMessage();
            return $this->api_response->getApiResponse($ch_result);
        }
}
