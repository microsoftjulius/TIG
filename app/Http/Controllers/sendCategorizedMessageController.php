<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\category;
use App\PackagesModel as packages;
use App\messages as message;
use Carbon\Carbon;
use Auth;
use App\package_category;
use GuzzleHttp\Client;
use App\SendersNumber;

class sendCategorizedMessageController extends Controller
{
    public function __construct(){
        $this->error_message = new ErrorMessagesController();
        $this->api_response  = new APIResponseMessage();
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
        //return $this->category_id;
        $packaged_categories = SendersNumber::join('package_category','package_category.category_id','senders_number.category_id')
        ->where('senders_number.category_id',$this->category_id)->get(); //->where('messages.transaction_status','like', 'F%')
        //return $packaged_categories;
        foreach($packaged_categories as $packaged_category){
            //return $packaged_category;
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
            return $this->error_message->emptyCategoryError();
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
            if(package_category::where('category_id',$this->category_id)->doesntExist()){
                return $this->sendPackagelessMessage();
            }else{
                return $this->categoryWithPackage();
            }
        }else{
            return redirect()->back()->withErrors("Please select atleast one category");
        }
    }

    protected function sendPackagelessMessage(){
        $no_package = SendersNumber::where('category_id',$this->category_id)->get();
        foreach($no_package as $no_package_subscription){
            array_push($this->contacts_array, $no_package_subscription->message_from);
        }
        return $this->sendMessageOnConnectedInternet();
    }

    public function sendCategorizedMessage(){
        if(empty(request()->scheduled_date)){
            if(package_category::where('category_id',$this->category_id)->exists()){
                return $this->categoryWithPackage();
            }else{
                return $this->categoryWithNoPackage();
            }
        }
        return $this->api_response->saveSentMessage();
    }

    protected function apiCall(){
        $unique_array = [];
        foreach($this->contacts_array as $unique){
            if(in_array($unique, $unique_array)){
                continue;
            }
            else{
                array_push($unique_array, $unique);
            }
        }
        $counted_valid = count($unique_array);
        if(count($this->contacts_array)<1){
            return $this->error_message->emptyCategoryError();
        }
        $unique_numbers = [];
        for($i=0; $i<count($this->contacts_array); $i++){
            if(in_array($this->contacts_array[$i], $unique_numbers)){
                continue;
            }else{
                array_push($unique_numbers, $this->contacts_array[$i]);
            }
        }
        $this->api_response->saveCategoriesSentMessage($counted_valid);

        $msgData_array = [];
        foreach($unique_numbers as $contacts){
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

        return $this->api_response->getApiResponse($ch_result);
    }
}
