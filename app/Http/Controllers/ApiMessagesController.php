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
    public function __construct(Request $request){
        $this->error404Error    = new ErrorMessagesController();
        $this->contact_id       = Contacts::where('contact_number',$request->from)->value('id');
        $this->church_id        = Contacts::where('contact_number',$request->from)->value('church_id');
    }
    public function createAPIMessage(Request $request) {
        if(empty($request->to) || empty($request->message) || empty($request->date_and_time) || empty($request->from)){
            return "All the supplied parameters are required";
        }
        if($this->contact_id){
                return $this->checkIfSearchTermExists($request);
            return $this->saveUncategorizedMessage($request);
        }else{
                return $this->createNewContactSubscriber($request);
        }
    }
    protected function saveUncategorizedMessage(Request $request){
        $message = new message();
        $message->category_id = null;
        $message->contact_id           = $this->contact_id;
        $message->send_to              = $request->to;
        $message->message              = $request->message;
        $message->time_from_app        = $request->date_and_time;
        $message->status               = 'Recieved';
        $message->church_id            = $this->church_id;
        $message->save();
        return response()->json([$message, 200]);
    }
    protected function createNewContactSubscriber(Request $request){
        Contacts::create(array('contact_number' => $request->from));
                $contact_id = Contacts::where('contact_number',$request->from)->value('id');
                $message = new message();
                $message->category_id = null;
                $message->contact_id           = $this->contact_id;
                $message->send_to              = $request->to;
                $message->message              = $request->message;
                $message->time_from_app        = $request->date_and_time;
                $message->status               = 'Recieved';
                $message->church_id            = $this->church_id;
                $message->save();
                return response()->json([$message]);
    }
    protected function checkIfSearchTermExists(Request $request){
        $registered_searchTerms = searchTerms::all();
        foreach($registered_searchTerms as $search_term){
            if(strpos($request->message, strtolower($search_term->search_term))){
                $category_id = searchTerms::where('search_term',strtolower($search_term->search_term))->value('category_id');
                $message = new message();
                $message->category_id          = $category_id;
                $message->contact_id           = $this->contact_id;
                $message->send_to              = $request->to;
                $message->church_id            = $this->church_id;
                $message->message              = $request->message;
                $message->time_from_app        = $request->date_and_time;
                $message->status      = 'Recieved';
                $message->save();
                return response()->json([$message, 200]);
            }
        }
    }
    public function getErrorMessageOnHttpGet(){
        return $this->error404Error->get404ErrorMessage();
    }
}
