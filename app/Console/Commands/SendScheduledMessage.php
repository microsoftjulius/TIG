<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\messages;
use App\Contacts;
use Carbon\Carbon;

class SendScheduledMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scheduled:message';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This Class sends a message to a subscriber when ever the scheduled time has reached';

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
        if(messages::where('tobesent_on',$mytime->toDateTimeString())->exists()){
            $message_to_send = messages::where('tobesent_on',$mytime->toDateTimeString())->get();
            foreach($message_to_send as $message){
                $contact = Contacts::where('contacts.group_id', $message->group_id)->get();
                foreach ($contact as $contacts) {
                    $data = array('method' => 'SendSms', 'userdata' => array('username' => 'microsoft',
                    'password' => '123456'
                    ), 'msgdata' => array(array('number' => $contacts->contact_number, 'message' => $message->message, 'senderid' => 'Good')));
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
            }
        }
    }
}
