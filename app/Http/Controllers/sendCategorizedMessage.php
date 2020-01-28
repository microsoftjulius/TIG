<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class sendCategorizedMessage extends Controller
{
    protected function checkIfMessageHasCategory(){

    }

    protected function checkIfContactSubcriptionIsStillOn(){

    }

    protected function sendMessageToSubscribers(){

    }

    protected function sendPackagelessMessage(){

    }

    public function sendCategorizedMessage(){
        if(packages::where('category_id', $this->category_id)->exists()){
            $package_days = packages::where('category_id',$this->category_id)->value('time_frame');
            $subscription_time = messages::where('category_id',$this->category_id)->value('time_from_app');
            $mytime = Carbon::now();
            $mytime->setTimezone('Africa/Kampala');
            if($subscription_time->addDays($package_days) > $mytime->toDateTimeString()){
                //send the message
            }
        }
    }
}
