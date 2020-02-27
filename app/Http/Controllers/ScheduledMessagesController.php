<?php

namespace App\Http\Controllers;

use App\messages;
use App\ScheduledMessages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduledMessagesController extends Controller
{
    public function displayScheduledMessages(){
        if(in_array('Can view scheduled messages',auth()->user()->getUserPermisions())){
            if(Auth::user()->church_id == 1){
                return $this->getAllScheduledMessagesToAdmin();
            }
            else{
                return $this->getAllScheduledMessagesToUsers();
            }
        }
        else{
            return redirect()->back();
        }
        
    }
    protected function getAllScheduledMessagesToAdmin(){
        $display_all_scheduled_messages = messages::where('messages.status', 'Scheduled')
        ->join('Groups','Groups.church_id','messages.church_id')
        ->join('church_databases','church_databases.id','messages.church_id')
        ->groupBy('messages.message')
        ->orderBy('messages.created_at','Desc')
        ->paginate('10');
        return view('after_login.scheduled-messages',compact('display_all_scheduled_messages'));
    }

    protected function getAllScheduledMessagesToUsers(){
        $display_all_scheduled_messages = messages::where('messages.status', 'Scheduled')
        ->join('Groups','Groups.church_id','messages.church_id')
        ->join('church_databases','church_databases.id','messages.church_id')
        ->where('Groups.church_id',Auth::user()->church_id)
        ->select('messages.message','Groups.group_name','messages.tobesent_on','messages.status','church_databases.church_name')
        ->groupBy('messages.message')
        ->orderBy('messages.created_at','Desc')
        ->paginate('10');
        return view('after_login.scheduled-messages',compact('display_all_scheduled_messages'));
    }

    public function searchScheduledMessages(Request $request){
        
    }
}
