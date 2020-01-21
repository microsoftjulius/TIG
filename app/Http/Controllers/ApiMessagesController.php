<?php

namespace App\Http\Controllers;

use App\category;
use App\Contacts;
use App\messages as message;
use App\Groups;
use App\searchTerms;
use App\ChurchHostedNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\MessagesCollection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Date;
use GuzzleHttp\Client;
use App\PackagesModel;

class ApiMessagesController extends Controller
{
    /**
     * The contact_number field is the hosted number litrary
     */
    public function __construct(Request $request){
        $this->error404Error    = new ErrorMessagesController();
        $this->contact_id       = ChurchHostedNumber::where('contact_number',$request->to)->value('id');
        $this->church_id        = ChurchHostedNumber::where('contact_number',$request->to)->value('church_id');
        $this->message_sent_to  = $request->to;
        $this->sent_message     = $request->message;
        $this->time_from_app    = $request->date_and_time;
        $this->senders_contact  = $request->from;
    }

    /**
     * Checks if all the parameters are filled
     * Calls all other functions
     */
    public function createAPIMessage(){
        if(empty($this->message_sent_to) || empty($this->sent_message) || empty($this->time_from_app) || empty($this->senders_contact)){
            return "All the supplied parameters are required";
        }
        if($this->contact_id){
            return $this->checkIfSearchTermExists();
        }
        else{
            return $this->createNewContactSubscriber();
        }
    }

    /**
     * Function saves uncategorized Message
     * Maps the Hosted contact number with the senders number
     */
    protected function saveUncategorizedMessage(){
        $message = new message();
        $message->category_id = null;
        $message->contact_id           = $this->contact_id;
        $message->message_from         = $this->senders_contact;
        $message->message              = $this->sent_message;
        $message->time_from_app        = $this->time_from_app;
        $message->status               = 'Recieved';
        $message->church_id            = $this->church_id;
        $message->save();
        return response()->json([$message, 200]);
    }

    /**
     * Function creates a new hosted contact
     * contact_number field is the hosted contact
     * it saves if a system recieves a message that is sent to an unhosted number 
     */
    protected function createNewContactSubscriber(){
        if($this->contact_id){
            Contacts::create(array('contact_number' => $this->message_sent_to));
            $message = new message();
            $message->category_id = null;
            $message->contact_id           = $this->contact_id;
            $message->message_from         = $this->senders_contact;
            $message->message              = $this->sent_message;
            $message->time_from_app        = $this->time_from_app;
            $message->status               = 'Recieved';
            $message->church_id            = $this->church_id;
            $message->save();
            return response()->json([$message]);
        }
        else{
            return $this->createNewContactToAMessageCategory();
        }
    }
    /**
     * Contact doesn't exist but message has a category
     * It occurs if the Message has been sent but to an unhosted contact
     * Its quite impossible since a number must have been hosted
     */
    protected function createNewContactToAMessageCategory(){
        Contacts::create(array('contact_number' => $this->message_sent_to));
        $this->contact_id = Contacts::where('contact_number', $this->message_sent_to)->value('id');
        $registered_searchTerms = searchTerms::all();
        $search_through_array = [];

        foreach($registered_searchTerms as $search_term){
            array_push($search_through_array, $search_term->search_term);
        }
            $targets = explode(' ', $this->sent_message);
            foreach ( $targets as $string ) 
            {
                foreach ( $search_through_array as $keyword ) 
                {
                    if ( strpos( $string, $keyword ) !== FALSE )
                        {
                            $category_id = searchTerms::where('search_term',strtolower($keyword))->value('category_id');
                            $message = new message();
                            $message->category_id          = $category_id;
                            $message->contact_id           = $this->contact_id;
                            $message->message_from         = $this->senders_contact;
                            $message->church_id            = $this->church_id;
                            $message->message              = $this->sent_message;
                            $message->time_from_app        = $this->time_from_app;
                            $message->status      = 'Recieved';
                            $message->save();
                            return response()->json([$message, 200]);
                        }
                }
            }
        return $this->saveUncategorizedMessage();
    } 

    /**
     * Function checks it the message has a search term
     * Maps the senders contact to the hosted contact
     * This function pops the message on a users phone to approve the payment
     */
    protected function checkIfSearchTermExists()
        {
            $registered_searchTerms = searchTerms::where('search_term','!=','default')->get();
            $search_through_array = [];
            foreach($registered_searchTerms as $search_term){
                array_push($search_through_array, $search_term->search_term);
            }
                $targets = explode(' ', $this->sent_message);
                foreach ( $targets as $string ) 
                {
                    foreach ( $search_through_array as $keyword ) 
                        {
                            if ( strpos( $string, $keyword ) !== FALSE )
                                {
                                    $category_id = searchTerms::where('search_term',strtolower($keyword))->value('category_id');
                                    if(PackagesModel::where('category_id',$category_id)->exists()){
                                        $amount = PackagesModel::where('category_id',$category_id)->value('Amount');
                                        $client = new Client();
                                        $response = $client->request('POST', 'https://app.beautifuluganda.com/api/payment/donate', [
                                            'form_params'   => [
                                            'name'          => 'TIG Test',
                                            'amount'        => $amount,
                                            'number'        => $this->senders_contact,
                                            'chanel'        => 'TIG',
                                            'referral'      => $this->senders_contact
                                            ]
                                        ]);
                                        if ($response->getStatusCode() == 200) { // 200 OK
                                            $response_data = $response->getBody()->getContents();
                                            $transaction_reference = json_decode($response_data, true);
                                            $transacting_code = $transaction_reference['data']['TransactionReference'];
                                            $transaction_status = $transaction_reference['data']['TransactionStatus'];
                                        }
                                        //Picking the church id from the number that has been hosted under the church, (the number to which the message is sent to) 
                                        $message = new message();
                                        $message->transaction_reference = $transacting_code;
                                        $message->category_id           = $category_id;
                                        $message->contact_id            = $this->contact_id;
                                        $message->message_from          = $this->senders_contact;
                                        $message->church_id             = $this->church_id;
                                        $message->message               = $this->sent_message;
                                        $message->time_from_app         = $this->time_from_app;
                                        $message->status                = 'Recieved';
                                        $message->transaction_status    = $transaction_status;
                                        $message->save();
                                        return response()->json([$message, 200]);
                                    }
                                    else{
                                        return $this->saveUncategorizedMessage();
                                    }
                                }
                        }
                }
        }
        
    /**
     * Function returns a 404 error page if a user performs a get request on the API route
     */
    public function getErrorMessageOnHttpGet(){
        return $this->error404Error->get404ErrorMessage();
    }
}
