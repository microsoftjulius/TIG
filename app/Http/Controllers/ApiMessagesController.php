<?php

namespace App\Http\Controllers;

use App\category;
use App\Contacts;
use App\messages as message;
use App\Groups;
use App\searchTerms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\MessagesCollection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Date;

class ApiMessagesController extends Controller
{
    /**
     * The contact_number fiel is the hosted number litrary
     */
    public function __construct(Request $request){
        $this->error404Error    = new ErrorMessagesController();
        $this->contact_id       = Contacts::where('contact_number',$request->to)->value('id');
        $this->church_id        = Contacts::where('contact_number',$request->to)->value('church_id');
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
        $registered_searchTerms = searchTerms::all();
        foreach($registered_searchTerms as $search_term){
            if(strpos($this->sent_message, strtolower($search_term->search_term))){
                $category_id = searchTerms::where('search_term',strtolower($search_term->search_term))->value('category_id');
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

    /**
     * Function checks it the message has a search term
     * Maps the senders contact to the hosted contact
     */
    protected function checkIfSearchTermExists(){
        $registered_searchTerms = searchTerms::all();
        foreach($registered_searchTerms as $search_term){
            if(strpos($this->sent_message, strtolower($search_term->search_term))){
                $category_id = searchTerms::where('search_term',strtolower($search_term->search_term))->value('category_id');
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
        return $this->saveUncategorizedMessage();
    }

    /**
     * Function returns a 404 error page if a user performs a get request on the API route
     */
    public function getErrorMessageOnHttpGet(){
        return $this->error404Error->get404ErrorMessage();
    }
}
