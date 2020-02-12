<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\SendersNumber;
use Carbon\Carbon;
use App\messages;

class ScheduleCategorizedMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scheduled:category';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This Schedular sends a categorized scheduled message';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $mytime = Carbon::now();
        $mytime->setTimezone('Africa/Kampala');

        if(messages::where('tobesent_on','<=',$mytime->toDateTimeString())->where('status','Scheduled')->exists()){
            $message_to_send = messages::where('tobesent_on','<=',$mytime->toDateTimeString())->where('status','Scheduled')
            ->join('senders_numbers','senders_numbers.category_id','messages.category_id')
            ->join('category','category.id','senders_numbers.category_id')
            ->select('messages.*','senders_numbers.contact')
            ->get();
            foreach($message_to_send as $message){
                $msgData_array = [];
                $contact = SendersNumber::join('messages','messages.category_id','senders_numbers.category_id')
                ->where('senders_numbers.category_id', $message->category_id)
                ->where('tobesent_on','<=',$mytime->toDateTimeString())->get();
                foreach ($contact as $contacts) {
                    if(in_array(array('number' => $contacts->contact, 'message' => $message->message, 'senderid' => 'Good'), $msgData_array)){
                        continue;
                    }else{
                        array_push($msgData_array, array('number' => $contacts->contact, 'message' => $message->message, 'senderid' => 'Good'));
                    }
                }
                    $data = array('method' => 'SendSms', 'userdata' => array('username' => 'microsoft',
                    'password' => '123456'
                    ), 'msgdata' => $msgData_array);
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
                    echo "sent";
                    messages::where('id',$message->id)->where('tobesent_on','<=',$mytime->toDateTimeString())
                    ->where('status','Scheduled')->update(array(
                        'status'=>'OK',
                        'number_of_contacts' => count($contact)
                    ));
                }
            }
    }
}
