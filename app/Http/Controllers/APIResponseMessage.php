<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\messages;
use Auth;
use App\Contacts;
use App\Groups;
use Carbon\Carbon;

class APIResponseMessage extends Controller
{
    public function __construct(){
        $this->error_message = new ErrorMessagesController();
        $this->category_id = request()->category;
        $this->message = request()->message;
        $this->groups_array    = request()->checkbox;
        $this->category_id = request()->category;
        $this->empty_array        = [];
        $this->valid_array        = [];
        $this->contacts_array     = [];
    }

    public function getValidAndEmptyGroups(){
        if(empty($this->groups_array)){
            return redirect()->back()->withErrors("Please Add a Group to continue");
        }
        foreach($this->groups_array as $group_id){
            if(Contacts::where('group_id',$group_id)->where('church_id',Auth::user()->church_id)->exists()){
                $group_contacts = Contacts::where('group_id',$group_id)->where('church_id',Auth::user()->church_id)
                ->get();
                foreach($group_contacts as $contacts){
                    array_push($this->valid_array, $contacts->contact_number);
                }
            }elseif(Contacts::where('group_id',$group_id)->where('church_id',Auth::user()->church_id)->doesntexist()){
                $empty_groups = Groups::where('id',$group_id)
                ->where('church_id',Auth::user()->church_id)
                ->get();
                foreach($empty_groups as $groups){
                    array_push($this->empty_array, $groups->group_name);
                }
            }
        }
    }

    public function saveGroupsSentMessage(){
        if(empty($this->groups_array)){
            return redirect()->back()->withErrors("Please Add a Group to continue");
        }
        foreach($this->groups_array as $group_id){
            $message = new messages();
            $message->group_id    = $group_id;
            $message->created_by  = Auth::user()->id;
            $message->message     = $this->message;
            $message->church_id   = Auth::user()->church_id;
            $message->number_of_contacts = request()->contact_character;
            $message->tobesent_on = Carbon::parse(request()->scheduled_date)->format('Y-m-d H:i:s');
            empty(request()->scheduled_date) ? $message->status  = 'OK' : $message->status  = 'Scheduled';

            empty(request()->scheduled_date) ? $msg = "Message has been sent Successfully" : $msg = "Message has successfully been Scheduled for ".request()->scheduled_date;
            $message->save();
            if(!empty(request()->scheduled_date)){
                return redirect()->back()->with('message',$msg);
            }
        }
        
    }

    public function saveCategoriesSentMessage($counted_valid){
        foreach($this->category_id as $category_id){
            $message = new messages();
            $message->created_by  = Auth::user()->id;
            $message->message     = $this->message;
            $message->number_of_contacts = request()->contact_character;
            $message->church_id   = Auth::user()->church_id;
            $message->category_id   = $category_id;
            $message->tobesent_on = Carbon::parse(request()->scheduled_date)->format('Y-m-d H:i:s');
            empty(request()->scheduled_date) ? $message->status  = 'OK' : $message->status  = 'Scheduled';

            empty(request()->scheduled_date) ? $msg = "Message has been sent Successfully" : $msg = "Message has successfully been Scheduled for ".request()->scheduled_date;
            $message->save();
            if(!empty(request()->scheduled_date)){
                return redirect()->back()->with('message',$msg);
            }
        }
        
    }

    public function getValidArray(){
        return $this->valid_array;
    }

    public function getEmptyArray(){
        return $this->empty_array;
    }

    public function getApiResponse($ch_result){
        $empty_array = [];
        $message_response = json_decode($ch_result, true);
        if(empty($message_response)){
            return $this->error_message->checkBrowsersInternetConnection();
        }
        foreach($message_response as $res){
            array_push($empty_array, $res);
        }
        if(is_numeric($empty_array[1])){
            if(!empty($this->getEmptyArray())){
                return redirect()->back()->with('message',"Message sending was successful. 
                However, the folowing Group(s) : " . implode(' ,', $this->empty_array) . " were Empty");
            }elseif(empty(request()->scheduled_date)){
                return redirect()->back()->with('message','Message has been sent successfully');
            }
            else{
                return redirect()->back()->with('message', "Message has successfully been Scheduled for ".request()->scheduled_date);
            }
        }else{
            messages::where('message',$this->message)->where('church_id',Auth::user()->church_id)
            ->update(array('status'=>'Failed'));
            return redirect()->back()->withErrors($empty_array[1]);
        }
    }
}
