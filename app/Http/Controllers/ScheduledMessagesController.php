<?php

namespace App\Http\Controllers;

use App\messages;
use App\ScheduledMessages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduledMessagesController extends Controller
{
    public function displayScheduledMessages(){
        if(Auth::user()->church_id == 1){
        $display_all_scheduled_messages = messages::join('Groups','messages.group_id','Groups.id')
        ->join('church_databases','church_databases.id','messages.church_id')
        ->where('messages.status', 'Scheduled')
        ->select('messages.message','Groups.group_name','messages.tobesent_on','messages.status','church_databases.church_name')
        ->orderBy('messages.id','Desc')
        ->paginate('10');
        return view('after_login.scheduled-messages',compact('display_all_scheduled_messages'));
        }else{
        $display_all_scheduled_messages = messages::join('Groups','messages.group_id','Groups.id')
        ->join('church_databases','church_databases.id','messages.church_id')
        ->join('users','users.church_id','church_databases.id')
        ->where('messages.status', 'Scheduled')
        ->where('users.id',Auth::user()->id)
        ->select('messages.message','Groups.group_name','messages.tobesent_on','messages.status','church_databases.church_name')
        ->orderBy('messages.id','Desc')
        ->paginate('10');
        return view('after_login.scheduled-messages',compact('display_all_scheduled_messages'));
        }
        
    }

    public function searchScheduledMessages(Request $request){
        
    }
}
