<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\messages;
use App\Contacts;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class SendingMessages extends Controller
{
    public function sendImmediateMessage(Request $request) {
        $mytime = Carbon::now();
        $mytime->setTimezone('Africa/Kampala');
        //return $mytime->toDateTimeString();
        if (empty($request->message)) {
            return Redirect()->back()->withInput()->withErrors("Make sure the Message Field is not Empty");
        }
        if (empty($request->checkbox)) {
            return Redirect()->back()->withInput()->withErrors("Make sure you have selected at least one group");
        }
        $message_to_send = $request->message;
        for($i = 0;$i < count($request->checkbox);$i++) {
            $contact = Contacts::where('contacts.group_id', $request->checkbox[$i])->get();
        if(Contacts::where('contacts.group_id', $request->checkbox[$i])->count() == 0){
            return Redirect()->back()->withInput()->withErrors("Some of the chosen groups have no contacts");
        }
        $mytime = Carbon::now();
        $mytime->setTimezone('Africa/Kampala');
        if($request->scheduled_date == $mytime->toDateTimeString() || $request->scheduled_date == null){
            foreach ($contact as $contacts) {
                $data = array('method' => 'SendSms', 'userdata' => array('username' => 'microsoft',
                'password' => '123456'
                ), 'msgdata' => array(array('number' => $contacts->contact_number, 'message' => $message_to_send, 'senderid' => 'Good')));
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
            }
            $empty_array = array();
            $message_response = json_decode($ch_result, true);
            if(empty($message_response)){
                return Redirect()->back()->withInput()->withErrors("check your internet connection");
            }
            foreach($message_response as $res){
                array_push($empty_array, $res);
            }
            if($empty_array[1] == 30){
                return redirect()->back()->withErrors("Message sending was successful");
            }
            messages::create(array('church_id' => Auth::user()->church_id, 'group_id' => $request->checkbox[$i],
        'message' => $request->message, 'tobesent_on' => null, 'status'=>$empty_array[0], 'created_by' => Auth::user()->id));
        }else{
            messages::create(array('church_id' => Auth::user()->church_id, 'group_id' => $request->checkbox[$i],
            'message' => $request->message, 'tobesent_on' => Carbon::createFromTimeStamp(strtotime($request->scheduled_date))->format('Y-m-d H:i:s'), 'status'=>'Scheduled', 'created_by' => Auth::user()->id));

            return redirect()->back()->withErrors("Message has been scheduled for " . Carbon::createFromTimeStamp(strtotime($request->scheduled_date))->format('Y-m-d H:i:s'));
        }
    }
        return redirect()->back()->withErrors("You have insufficient balance on your account. Please recharge and try again");
    }
}
