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
use App\package_category;
use App\SendersNumber;

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
        $this->status_response  = "OK";
        $this->status_code      = 200;

        //return $request->to;
    }

    /**
     * Checks if all the parameters are filled
     * Calls all other functions
     */
    public function createAPIMessage(){
        if(empty($this->message_sent_to) || empty($this->sent_message) || empty($this->time_from_app) || empty($this->senders_contact)){
            return "All the supplied parameters are required";
        }
        if($this->getRecieverContact()){
            return $this->getFirstSearchTerm();
        }
        else{
            return $this->saveMessageWithNoContact();
        }
    }

    protected function getRecieverContact(){
        return $this->contact_id;
    }

    /**
     * This function gets the church that has registered the recieved number
     */
    protected function getContactsChurch(){
        $this->church_id = ChurchHostedNumber::where('contact_number',request()->to)->value('church_id');
        return $this->church_id;
    }

    /**
     * This function gets all the search terms registered under this church
     */
    protected function getChurchSearchTerms(){
        $church_search_terms = searchTerms::where('church_id', $this->getContactsChurch())
        ->where('search_term','!=','default')
        ->get();
        return $church_search_terms;
    }

    protected function incrementCategoryNumbersCount($category_id){
        if(message::where('category_id',$category_id)->where('contact',$this->senders_contact)->doesntExist()){
            $number_of_registered_subscribers = category::where('id',$category_id)->value('number_of_subscribers');
            category::where('id',$category_id)->update(array('number_of_subscribers'=>$number_of_registered_subscribers + 1));
        }
    }
    /**
     * This function save a categorized message. It only saves it if the category
     * has no payment package attached to it
     */
    protected function saveCategorizedMessage(){
        $this->incrementCategoryNumbersCount($category_id);
        $senders_contact = new SendersNumber();
        if(SendersNumber::where('contact',$this->senders_contact)->doesntExist()){
            $senders_contact->contact = $this->senders_contact;
            $senders_contact->category_id           = $category_id;
            $senders_contact->save();
        }
        $senders_contact_id = SendersNumber::where('contact',$this->senders_contact)->value('id');
        $message = new message();
        $message->contact_id            = $this->getRecieverContact();
        $message->message_from          = $senders_contact_id;
        $message->church_id             = $this->getContactsChurch();
        $message->message               = $this->sent_message;
        $message->time_from_app         = $this->time_from_app;
        $message->status                = 'Recieved';
        $message->save();
    }
    /**
     * This function saves checks if the message does not belong to any category
     * Saves the message as uncategorized under a church that has the message to as hosted
     */

    protected function saveUncategorizedMessage(){
        $senders_contact = new SendersNumber();
        if(SendersNumber::where('contact',$this->senders_contact)->doesntExist()){
            $senders_contact->contact = $this->senders_contact;
            $senders_contact->category_id = null;
            $senders_contact->save();
        }
        $senders_contact_id = SendersNumber::where('contact',$this->senders_contact)->value('id');
        $message = new message();
        $message->contact_id           = $this->getRecieverContact();
        $message->message_from         = $senders_contact_id;
        $message->message              = $this->sent_message;
        $message->time_from_app        = $this->time_from_app;
        $message->status               = 'Recieved';
        $message->church_id            = $this->getContactsChurch();
        $message->save();
        return response()->json([$message, $this->status_response]);
    }

    protected function saveMessageWithNoContact(){
        $senders_contact = new SendersNumber();
        if(SendersNumber::where('contact',$this->senders_contact)->doesntExist()){
            $senders_contact->contact = $this->senders_contact;
            $senders_contact->category_id = null;
            $senders_contact->save();
        }
        $senders_contact_id = SendersNumber::where('contact',$this->senders_contact)->value('id');
        $message = new message();
        $message->contact_id           = null;
        $message->wrong_contact        = $this->message_sent_to;
        $message->message_from         = $senders_contact_id;
        $message->message              = $this->sent_message;
        $message->time_from_app        = $this->time_from_app;
        $message->status               = 'Recieved';
        $message->church_id            = $this->getContactsChurch();
        $message->save();
        return response()->json([$message, $this->status_response]);
    }
    /**
     * This function searches through the message to find the registered search term
     */

    protected function getFirstSearchTerm()
        {
            $search_through_array = [];
            foreach($this->getChurchSearchTerms() as $search_term){
                array_push($search_through_array, $search_term->search_term);
            }
                $targets = explode(' ', $this->sent_message);
                foreach ( $targets as $string ) 
                {
                    if(empty($search_through_array)){
                        return $this->saveUncategorizedMessage();
                    }
                    foreach ( $search_through_array as $keyword ) 
                        {
                            if ( strpos( $string, $keyword ) !== FALSE )
                                {
                                    $category_id = searchTerms::where('search_term',strtolower($keyword))->where('church_id', $this->getContactsChurch())->value('category_id');
                                    if(package_category::where('category_id',$category_id)->where('church_id', $this->getContactsChurch())->exists()){
                                        $amount = PackagesModel::join('package_category','package_category.package_id','packages.id')
                                        ->where('package_category.category_id',$category_id)->where('package_category.church_id', $this->getContactsChurch())->value('Amount');
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
                                        if ($response->getStatusCode() == $this->status_code) { // $this->status_response OK
                                            $response_data = $response->getBody()->getContents();
                                            $transaction_reference = json_decode($response_data, true);
                                            $transacting_code = $transaction_reference['data']['TransactionReference'];
                                            $transaction_status = $transaction_reference['data']['TransactionStatus'];
                                        }
                                        //Picking the church id from the number that has been hosted under the church, (the number to which the message is sent to) 
                                        $this->incrementCategoryNumbersCount($category_id);
                                        $senders_contact = new SendersNumber();
                                        if(SendersNumber::where('contact',$this->senders_contact)->doesntExist()){
                                            $senders_contact->contact = $this->senders_contact;
                                            $senders_contact->category_id           = $category_id;
                                            $senders_contact->save();
                                        }
                                        $senders_contact_id = SendersNumber::where('contact',$this->senders_contact)->value('id');
                                        $message = new message();
                                        $message->transaction_reference = $transacting_code;
                                        $message->contact_id            = $this->contact_id;
                                        $message->message_from          = $senders_contact_id;
                                        $message->church_id             = $this->church_id;
                                        $message->message               = $this->sent_message;
                                        $message->time_from_app         = $this->time_from_app;
                                        $message->status                = 'Recieved';
                                        $message->transaction_status    = $transaction_status;
                                        $message->save();
                                        return response()->json([$message, $this->status_response]);
                                    }
                                    
                                    else{
                                        $this->incrementCategoryNumbersCount($category_id);
                                        $senders_contact = new SendersNumber();
                                        if(SendersNumber::where('contact',$this->senders_contact)->doesntExist()){
                                            $senders_contact->contact = $this->senders_contact;
                                            $senders_contact->category_id = $category_id;
                                            $senders_contact->save();
                                        }
                                        $senders_contact_id = SendersNumber::where('contact',$this->senders_contact)->value('id');
                                        $message = new message();
                                        $message->contact_id            = $this->getRecieverContact();
                                        $message->message_from          = $senders_contact_id;
                                        $message->church_id             = $this->getContactsChurch();
                                        $message->message               = $this->sent_message;
                                        $message->time_from_app         = $this->time_from_app;
                                        $message->status                = 'Recieved';
                                        $message->save();
                                        return response()->json([$message, $this->status_response]);
                                    }
                                }
                                
                        }
                        
                }
                return $this->saveUncategorizedMessage();
        }
    public function getErrorMessageOnHttpGet(){
        return $this->error404Error->displayOnUsingGetInTheApi();
    }
}
