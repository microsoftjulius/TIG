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

    /** Function to send immediate message with category, it has a pakage attached to it*/
    protected function categoryWithPackage(){
        $mytime = Carbon::now();
        $mytime->setTimezone('Africa/Kampala');
        //return $this->category_id;
        $packaged_categories = SendersNumber::join('messages','messages.category_id','senders_numbers.category_id')
        ->where('messages.transaction_status','SUCCEEDED')
        ->where('messages.church_id',Auth::user()->church_id)->get(); //->where('messages.transaction_status','like', 'F%')
    //return $packaged_categories;
        $manual_subs = category::join('senders_numbers','senders_numbers.category_id','category.id')->where('category.church_id',Auth::user()->church_id)->get();
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
                array_push($this->contacts_array, $packaged_category->contact);
                }
            }
        }
        foreach($manual_subs as $subs){
            if($subs->contact == null){
                continue;
            }else{
            array_push($this->contacts_array, $subs->contact);
            }
        }
        //return $this->contacts_array;
        if(count($this->contacts_array) == 0){
            return $this->error_message->emptyCategoryError();
        } 
        return $this->sendMessageOnConnectedInternet();
    }
    /** Function to send message on connected internet */
    protected function sendMessageOnConnectedInternet(){
        return $this->apiCall();
    }
    /** Function to send message to category with no package */
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
    /** Function to send packageless message */
    protected function sendPackagelessMessage(){
        $no_package = SendersNumber::where('category_id',$this->category_id)->get();
        foreach($no_package as $no_package_subscription){
            array_push($this->contacts_array, $no_package_subscription->contact);
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
        return $this->apiCall();
    }


    protected function apiCall(){
        
        //Just put this
        $subscribers_array = [];
        if(empty(request()->scheduled_date)){
            $contacts = SendersNumber::where('messages.category_id',$this->category_id)
            ->join('messages','messages.message_from','senders_numbers.id')
            ->where('status','!=','Scheduled')->where('messages.transaction_status','SUCCEEDED')->get();
            
            foreach($contacts as $contact){
                array_push($subscribers_array, $contact->contact);
            }
        }
        else{
            return $this->api_response->saveCategoriesSentMessage($this->category_id);
        }
        $unique_array = [];
        foreach($subscribers_array as $unique){
            if(in_array($unique, $unique_array)){
                continue;
            }
            else{
                array_push($unique_array, $unique);
            }
        }
        $counted_valid = count($unique_array);
        if(empty($subscribers_array)){
            return redirect('/sent-quick-messages')->withErrors("The Entered Category has no subscribers");
            //return $this->error_message->emptyCategoryError();
        }
        $unique_numbers = [];
        for($i=0; $i<count($subscribers_array); $i++){
            if(in_array($subscribers_array[$i], $unique_numbers)){
                continue;
            }else{
                array_push($unique_numbers, $subscribers_array[$i]);
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
