<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\messages;
use Auth;

class UnCategorizedMessages extends Controller
{
    public function __construct(){
        $this->error_message    = new ErrorMessagesController();
        $this->api_response     = new APIResponseMessage();
        $this->message          = request()->message;
        $this->empty_array      = [];
        $this->valid_array      = [];
    }

    protected function getNumbersFromUncategorizedMessages(){
        if(Auth::user()->church_id == 1){
            $numbers = messages::where('messages.category_id',null)
            ->join('senders_numbers','senders_numbers.id','messages.message_from')->where('message_from','!=', null)
            ->get();
        }else{
            $numbers = messages::where('messages.church_id',Auth::user()->church_id)->where('messages.category_id',null)
            ->join('senders_numbers','senders_numbers.id','messages.message_from')->where('message_from','!=', null)->orderBy("messages.created_at","Desc")
            ->get();
        }
        return $numbers;
    }

    protected function saveUncategorizedMessage(){
        $message = new messages();
        $message->created_by = Auth::user()->id;
        $message->church_id  = Auth::user()->church_id;
        $message->message    = request()->message;
        $message->save();
    }

    public function sendMessage(Request $request){
        $msgData_array = [];
        if(empty($this->getNumbersFromUncategorizedMessages())){
            return $this->error_message->noNumbersFound();
        }
            foreach($this->getNumbersFromUncategorizedMessages() as $contacts){
                if(in_array(array('number' => $contacts->contact, 'message' => $this->message, 'senderid' => 'Good'), $msgData_array)){
                    continue;
                }else{
                    array_push($msgData_array, array('number' => $contacts->contact, 'message' => $this->message, 'senderid' => 'Good'));
                }
            }
            $this->saveUncategorizedMessage();

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

            messages::where('church_id',Auth::user()->church_id)->where('message',request()->message)->update(array('number_of_contacts'=>count($msgData_array)));

            return $this->api_response->getApiResponse($ch_result);
    }
}
