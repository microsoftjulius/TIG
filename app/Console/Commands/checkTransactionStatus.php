<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use App\messages;
use Carbon\Carbon;

class checkTransactionStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:transactions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This Cron Job runs (calls) the Given Mobile money API to get he status every second.
                                it stops checking the status of a row after 7 minutes';

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
        $transactionTime = messages::where('transaction_status','!=','OK')
        ->where('time_from_app','<',$mytime->subMinutes(7))
        ->get();
        foreach($transactionTime as $transactions){
            $client = new Client();
            $request = $client->get('https://app.beautifuluganda.com/statuspayment?ref='.$transactions->transaction_reference);
            if($request->getStatusCode() == 200) { // 200 OK
                $response_data = $request->getBody()->getContents();
                $transaction_reference = json_decode($response_data, true);
                $transaction_status = $transaction_reference['data']['TransactionStatus'];
                $message = new messages();
                $message->where('transaction_reference',$transactions->transaction_reference)
                ->update(array('transaction_status' => $transaction_status));
            }
        }
        echo "done";
    }
}
