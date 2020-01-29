<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\category;
use App\PackagesModel as packages;
use App\messages as message;
use Carbon\Carbon;
use Auth;
use GuzzleHttp\Client;

class sendCategorizedMessageController extends Controller
{
    public function __construct(){
        $this->error_message = new ErrorMessagesController();
        $this->category_id = request()->category;
        $this->message = request()->message;
        $this->contacts_array = [];

        //Checking browsers internet connection
        $host_name = 'www.google.com';
        $port_no = '80';
        $this->connected = (bool)@fsockopen($host_name, $port_no, $err_no, $err_str, 10);
    }

    protected function categoryWithPackage(){
        $mytime = Carbon::now();
        $mytime->setTimezone('Africa/Kampala');
        $packaged_categories = message::join('packages','packages.category_id','messages.category_id')
        ->where('messages.category_id',$this->category_id)->where('messages.transaction_status','like', 'F%')->get();
        foreach($packaged_categories as $packaged_category){
            $final_day_of_subscription = Carbon::parse($packaged_category->time_from_app)->addDays($packaged_category->time_frame);
            $subscription_final_day = $final_day_of_subscription->toDateTimeString();
            //check if the contact subscription days are still on
            if($mytime->toDateTimeString() < $subscription_final_day){
                if($packaged_category->message_from == null){
                    continue;
                }else{
                array_push($this->contacts_array, $packaged_category->message_from);
                }
            }
        }
        if(count($this->contacts_array) == 0){
            return redirect()->back()->withErrors("The Selected category has no subscribers");
        } 
        return $this->sendMessageOnConnectedInternet();
    }

    protected function sendMessageOnConnectedInternet(){
        return $this->apiCall();
    }

    protected function categoryWithNoPackage(){
        
        if(empty($this->message)){
            return redirect()->back()->withErrors("The Message Body cannot be empty");
        }
        if(!empty(request()->category)){
            if(packages::where('category_id',$this->category_id)->doesntExist()){
                return $this->sendPackagelessMessage();
            }else{
                return $this->categoryWithPackage();
            }
        }else{
            return redirect()->back()->withErrors("Please select atleast one category");
        }
    }

    protected function sendPackagelessMessage(){
        $no_package = message::where('category_id',$this->category_id)
        ->where('message_from','!=',null)->get();
        foreach($no_package as $no_package_subscription){
            array_push($this->contacts_array, $no_package_subscription->message_from);
        }
        return $this->sendMessageOnConnectedInternet();
    }

    protected function saveSentMessage(){
        $message = new message();
        $message->category_id = $this->category_id;
        $message->created_by  = Auth::user()->id;
        $message->message     = $this->message;
        $message->church_id   = Auth::user()->church_id;
        $message->tobesent_on = request()->scheduled_date;
        empty(request()->scheduled_date) ? $message->status  = '' : $message->status  = 'Scheduled';

        empty(request()->scheduled_date) ? $msg = "Message has been sent Successfully" : $msg = "Message has successfully been Scheduled for ".request()->scheduled_date;
        $message->save();
        return redirect()->back()->with('message',$msg);
        
    }

    public function sendCategorizedMessage(){
        if(empty(request()->scheduled_date)){
            if(packages::where('category_id',$this->category_id)->exists()){
                return $this->categoryWithPackage();
            }else{
                return $this->categoryWithNoPackage();
            }
        }
        return $this->saveSentMessage();
    }

    protected function apiCall(){
        if(count($this->contacts_array)<1){
            return redirect()->back()->withErrors("The selected category has no subscribers");
        }
        //removing identical numbers before sending the message
        $unique_numbers = [];
        for($i=0; $i<count($this->contacts_array); $i++){
            if(in_array($this->contacts_array[$i], $unique_numbers)){
                continue;
            }else{
                array_push($unique_numbers, $this->contacts_array[$i]);
            }
        }
        foreach($unique_numbers as $contacts){
            $data = array('method' => 'SendSms', 'userdata' => array('username' => 'microsoft',
        'password' => '123456'
        ), 'msgdata' => array(array('number' => $contacts, 'message' => $this->message, 'senderid' => 'Good')));
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

        $empty_array = [];
        $message_response = json_decode($ch_result, true);
        if(empty($message_response)){
            return $this->error_message->checkBrowsersInternetConnection();
        }
        foreach($message_response as $res){
            array_push($empty_array, $res);
        }
        if(is_numeric($empty_array[1])){
            return redirect()->back()->with('message',"Message sending was successful");
        }else{
            return redirect()->back()->withErrors("You have insufficient balance on your account. Please recharge and try again");
        }
    }
}
