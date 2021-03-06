<?php
namespace App\Http\Controllers;

use App\category;
use App\Contacts;
use App\messages as message;
use App\Groups;
use App\SendersNumber;
use DB;
use App\searchTerms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\MessagesCollection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Date;

class messages extends Controller 
{
    public function __construct(Request $request){
        $this->search_message = $request->search_message;
        $this->message_from   = $request->from;
        $this->message_to     = $request->to;
    }

    /**
     * Function to display Sent messages to the administrator
     */
    protected function displaySentMessagesToAdmin(){
        $display_sent_message_details = message::where('status','OK')
        ->join('users','users.id','messages.created_by')
        ->join('church_databases','church_databases.id','users.church_id')
        ->orderBy('messages.created_at','Desc')
        ->groupBy('messages.message')
        ->select('messages.*','users.id','users.email','church_databases.church_name')
        ->paginate(10);
        return view('after_login.sent-messages', compact('display_sent_message_details'));
    }

    /**
     * Function to display Sent messages to the Individual Users
     */
    protected function displaySentMessagesToUsers(){
        $display_sent_message_details = message::where('status','OK')
        ->join('users','users.id','messages.created_by')
        ->where('messages.church_id',Auth::user()->church_id)
        ->orderBy('messages.created_at','Desc')
        ->groupBy('messages.message')
        ->select('messages.*','users.id','users.email')
        ->paginate(10);
        return view('after_login.sent-messages', compact('display_sent_message_details'));
    }

        
    /**
     * Function to display uncategorized messages to admin
     */
    protected function displayUncategorizedMessageToAdmin(){
        $uncategorized_messages = message::join('ChurchHostedNumber','messages.contact_id','ChurchHostedNumber.id')
        ->join('senders_numbers','senders_numbers.id','messages.message_from')
        ->where('messages.category_id',null)
        ->where('status','Recieved')
        ->select('messages.message','messages.id','ChurchHostedNumber.contact_number','messages.created_at','senders_numbers.contact')
        ->groupBy('messages.message')->orderBy("messages.created_at","Desc")
        ->paginate('10');
        return view('after_login.uncategorized_messages',compact('uncategorized_messages'));
    }

    /**
     * Function to display wrong contact messages to admin
     */
    public function displayWrongMessageToAdmin(){
        if(in_array('Can view wrong contact messages',auth()->user()->getUserPermisions())){
        $uncategorized_messages = message::where('wrong_contact','!=','')
        ->join('senders_numbers','senders_numbers.id','messages.message_from')
        ->select('messages.message','messages.id','messages.created_at','senders_numbers.contact','messages.wrong_contact')->paginate('10');
        return view('after_login.Wrong-contacts',compact('uncategorized_messages'));
        }
        else{
            return redirect()->back();
        }
    }

    /**
     * Function to display uncategorized messages to the admin
     */
    protected function displayUncategorizedMessageToUser(){
        $uncategorized_messages = message::join('ChurchHostedNumber','messages.contact_id','ChurchHostedNumber.id')
        ->join('senders_numbers','senders_numbers.id','messages.message_from')
        ->where('messages.category_id',null)
        ->where('status','Recieved')
        ->where('messages.church_id',Auth::user()->church_id)
        ->select('messages.message','messages.id','ChurchHostedNumber.contact_number','messages.created_at','senders_numbers.contact')
        ->groupBy('messages.message')->orderBy("messages.created_at","Desc")
        ->paginate('10');
        return view('after_login.uncategorized_messages',compact('uncategorized_messages'));
    }


    /**
     * Function to check if senders number and recievers numbers exist
     */
    protected function checkSendersNumberAndRecieversNumberEmpty(){
        $messages_to_categories = message::join('category','messages.category_id','category.id')
        ->where('title',$this->search_message)->paginate('10');
        $drop_down_categories = category::where('church_id', Auth::user()->church_id)
        ->select("title", "user_id", "id")->paginate(10);
        return view('after_login.incoming-messages',compact('messages_to_categories','drop_down_categories'));
    }

    /**
     * Function to check if senders number is empty
     */
    protected function checkSendersNumberEmpty(){
        $messages_to_categories = message::join('category','messages.category_id','category.id')
        ->where('messages.created_at',[Date::make($this->message_to)->format('Y-m-d H-i-s')])
        ->where('title',$this->search_message)->paginate('10');
        $drop_down_categories = category::where('church_id', Auth::user()->church_id)
        ->select("title", "user_id", "id")->paginate(10);
        return view('after_login.incoming-messages',compact('messages_to_categories','drop_down_categories'));
    }

    /**
     * Function to check if the recievers number is empty
     */
    protected function checkRecieversNumberEmpty(){
        $messages_to_categories = message::join('category','messages.category_id','category.id')
        ->where('messages.created_at',[Date::make($this->message_from)->format('Y-m-d H-i-s')])
        ->where('title',$this->search_message)->paginate('10');
        $drop_down_categories = category::where('church_id', Auth::user()->church_id)
        ->select("title", "user_id", "id")->paginate(10);
        return view('after_login.incoming-messages',compact('messages_to_categories','drop_down_categories'));
    }

    /**
     * Function to get all messages and categories for a church
     */
    protected function getMessageAndCategory(){
        $messages_to_categories = message::join('category','messages.category_id','category.id')
        ->whereBetween('messages.created_at',[Date::make($this->message_from)->format('Y-m-d H-i-s'), Date::make($this->message_to)->format('Y-m-d H-i-s')])
        ->where('title',$this->search_message)->where('category.church_id',Auth::user()->church_id)->orderBy('messages.id','desc')->paginate('10');

        $drop_down_categories = category::where('church_id', Auth::user()->church_id)
        ->select("title", "user_id", "id")->paginate(10);
        return view('after_login.incoming-messages',compact('messages_to_categories','drop_down_categories'));
    }

    /**
     * Function to search contact group
     */
    public function search_use_contact_group_attributes(Request $request){
        $search = $request->search;
        $display_sent_message_details = message::where('created_by', $search)->where('church_id', Auth::user()->church_id)
        ->where('status','!=','Deleted')->orderBy('id','desc')
        ->paginate('10');
        return view('after_login.sent-messages', compact('display_sent_message_details'));
    }

    /**
     * Function to displacy sent messages
     */
    public function display_sent_messages(){
        if(in_array('Can view sent messages',auth()->user()->getUserPermisions())){
            if(auth()->user()->id == 1){
                return $this->displaySentMessagesToAdmin();
            }else{
                return $this->displaySentMessagesToUsers();
            }
        }
        else{
            return redirect()->back();
        }
    }

    /**
     * Function to get Groups for quick sms dropdown
     */
    public function drop_down_groups() {
        // if(Auth::user()->church_id == 1){
        //     return $this->getCategoriesForChurch();
        // }else{
            if(in_array('Can Send a Quick Message',auth()->user()->getUserPermisions())){
                return $this->getCategoriesForChurch();
            }else{
                return redirect()->back();
            }
       //}
    }

    protected function getCategoriesForAdmin(){
        $drop_down_groups = Groups::select("group_name", "number_of_contacts", "id")->get();
        
        $categories = category::select('title','id','number_of_subscribers')->get();

        return view('after_login.Quicksms', compact('drop_down_groups','categories','no_category'));
    }

    protected function getCategoriesForChurch(){
        $drop_down_groups = Groups::where('church_id', Auth::user()->church_id)
        ->select("group_name", "number_of_contacts", "id")->get();
        
        $categories = category::where('church_id',Auth::user()->church_id)
        ->select('title','id','number_of_subscribers')->get();
        return view('after_login.Quicksms', compact('drop_down_groups','categories'));
    }

    /**
     * Function to display contact groups blade
     */
    public function contact_groups(Request $request) {
        return view('after_login.groups');
    }

    /**
     * Function to search messages and display them on the sent-messages blade
     */
    public function search_messages(Request $request) {
        $display_sent_message_details = message::where('message', $this->search_message)->orWhere('message', 'like', '%' . $this->search_message . '%')->where('church_id', Auth::user()->church_id)
        ->where('status','Recieved')
        ->paginate('10');
        return view('after_login.sent-messages', compact('display_sent_message_details'))->with(['search_query' => $this->search_message]);
    }

    /**
     * Function to search message categories
     */
    public function search_message_categories(Request $request) {
        $category = searchTerms::join('users', 'users.id', 'search_terms.user_id')
        ->join('church_databases','church_databases.id','search_terms.church_id')
        ->join('category','category.id','search_terms.category_id')
        ->where('church_databases.id',Auth::user()->church_id)
        ->Where('title', 'like', '%' . $request->category . '%')
        ->orWhere('name', 'like', '%' . $request->category . '%')
        ->select(array('category.id','title', 'name', DB::raw('COUNT(search_terms.search_term) as countSearchTerms')))
        ->groupBy('category.title')->paginate('10');
        return view('after_login.message-categories', compact('category'))
        ->with(['search_query' => $request->search_category]);
    }

    /**
     * Function to show add category blade
     */
    public function show_add_category_blade(){
        return view('after_login.add-message-category');
    }

    /**
     * function to save message category
     */
    public function save_message_category(Request $request) {
        if(category::where('church_id',Auth::user()->church_id)->where('title',$request->category)->exists()){
            return Redirect()->back()->withInput()->withErrors("Message category is already registered");
        }else{
            category::create(array(
                'church_id' => Auth::user()->church_id, 
                'title'     => strtolower($request->category),
                'user_id'   =>  Auth::user()->id,
            ));
            $id = category::where('title',$request->category)->value('id');
            searchTerms::create(array(
            'user_id'       => Auth::user()->id,
            'church_id'     => Auth::user()->church_id,
            'category_id'   => $id,
            'search_term'   => 'default',
            ));
            return redirect('/message-categories')->with('message', 'Message Category was added Successfully');
        }
    }

    /**
     * Function to save added search terms
     */
    public function save_added_search_terms(Request $request) {
        message::create(array('church_id' => Auth::user()->church_id, 'search_term_name' => $request->search_term_name, 'search_terms_list'->$request->search_terms_list));
    }

    /**
     * Function to display message categories page
     */
    public function message_categories_page() {
        if(in_array('Can view scheduled messages',auth()->user()->getUserPermisions())){
            $category = searchTerms::join('users', 'users.id', 'search_terms.user_id')
            ->join('church_databases','church_databases.id','search_terms.church_id')
            ->join('category','category.id','search_terms.category_id')
            ->where('church_databases.id',Auth::user()->church_id)
            ->select(array('category.id','title', 'name','category.number_of_subscribers', DB::raw('COUNT(search_terms.search_term) as countSearchTerms')))
            ->groupBy('category.title')
            ->paginate('10');
            return view('after_login.message-categories', compact('category'));
        }else{
            return redirect()->back();
        }
    }

    /**
     * Function to show search terms
     */
    public function show_search_terms(Request $request, $id) {
        $search_terms = searchTerms::join('users','users.id','search_terms.user_id')
        ->where('users.church_id',Auth::user()->church_id)
        ->where('category_id',$id)->get();
        return view('after_login.search-term-table',compact('search_terms'));
    }

    /**
     * Function to save search terms
     */
    public function save_search_terms(Request $request, $id) {
        if(empty($request->new_search_term)){
            return redirect()->back()->withErrors("Search term cannot be null");
        }
        if($request->new_search_term == "default"){
            return redirect()->back()->withErrors("Default is a reserved word, Choose another word.
            We greatly appologise for the inconviniences caused");
        }
        if(searchTerms::where('church_id',Auth::user()->church_id)->where('search_term',$request->new_search_term)->exists()){
            return redirect()->back()->withErrors("Search term is already registered, choose another search term");
        }
        
        $search_term = new searchTerms();
        $search_term->user_id = Auth::user()->id;
        $search_term->church_id = Auth::user()->church_id;
        $search_term->category_id = $id;
        $search_term->search_term = $request->new_search_term;
        $search_term->save();
        return Redirect()->back()->with('message', 'Such Term Added Successfully');     
    }

    /**
     * Function to delete Search term
     */
    public function deleteSearchTerm($id, Request $request){
        searchTerms::where('id',$id)->delete();
        return Redirect()->back()->with('message', 'Such Term was deleted Successfully');
    }

    /**
     * Function to display message categories, search terms, users
     */
    public function display_message_category_form($id){
        $all_search_terms = searchTerms::join('category','category.id','search_terms.category_id')
        ->join('users','users.id','search_terms.user_id')
        ->where('search_terms.church_id',Auth::user()->church_id)
        ->where('search_terms.search_term','!=','default')
        ->where('category_id',$id)
        ->select('users.name','category.title','search_terms.*')
        ->paginate(10);
        
        $count_subscribers = SendersNumber::where('category_id',$id)->count();
        return view('after_login.search-term-table',compact('all_search_terms','count_subscribers'));
    }

    /**
     * Function to edit a message category
     */
    public function edit_message_category(Request $request, $id){
        if(category::where('church_id',Auth::user()->church_id)->where('title',$request->new_category_title)->exists()){
            return redirect()->back()->withinput()->withErrors("Cannot update category to that name since a category with that name already exists");
        }
        category::where('id',$id)->update(
            array('title'=> $request->new_category_title)
        );
        return redirect('/message-categories')->with('message', 'Category Update Was Successful');
    }

    /**
     * Function to show incoming messages
     */
    public function show_incoming_messages(){
        if(in_array('Can view incoming messages',auth()->user()->getUserPermisions())){
            if(Auth::user()->church_id == 1){
                return $this->showIncomingMessagesToAdmin();
            }
            else{
                return $this->showIncomingMessagesToChurch();
            }
        }else{
            return redirect()->back();
        }
    }

    /**
     * This function shows incoming messages to the admin
     */
    protected function showIncomingMessagesToAdmin(){
        $messages_to_categories = message::join('senders_numbers','senders_numbers.id','messages.message_from')
        ->join('category','category.id','messages.category_id')
        ->where('messages.status','Recieved')->orderBy("messages.created_at","Desc")
        ->paginate('10');

        $drop_down_categories = category::select("title", "user_id", "id")->paginate(10);
        return view('after_login.incoming-messages',compact('messages_to_categories','drop_down_categories'));
    }

    /**
     * This function shows incoming messages to the church
     */
    protected function showIncomingMessagesToChurch(){
        $messages_to_categories = message::join('senders_numbers','senders_numbers.id','messages.message_from')
        ->where('messages.church_id',Auth::user()->church_id)
        ->join('category','category.id','messages.category_id')->orderBy("messages.created_at","Desc")
        ->where('messages.status','Recieved')
        ->paginate('10');
        
        $drop_down_categories = category::where('church_id', Auth::user()->church_id)
        ->select("title", "user_id", "id")->paginate(10);
        return view('after_login.incoming-messages',compact('messages_to_categories','drop_down_categories'));
    }
    /**
     * Function to display search terms
     */
    public function display_search_terms(){
        $all_search_terms = searchTerms::all();
        return $all_search_terms;
    }

    /**
     * Function to show uncategorized messages
     */
    public function showUnCategorizedMessages(){
        if(Auth::user()->church_id == 1){
            return $this->displayUncategorizedMessageToAdmin();
        }
        else{
            return $this->displayUncategorizedMessageToUser();
        }
    }

    /**
     * Function to delete uncategorized messages
     */
    public function deleteUncategorizedMessage($id){
        message::where('id',$id)->update(array(
            'status' => 'Deleted',
            'created_by' => Auth::user()->id
        ));
        return Redirect()->back()->with('message', 'Message Deletion Was Successful');
    }

    /**
     * Function to display deleted messages
     */
    public function showDeletedMessages()
    {
        $uncategorized_messages = message::join('contacts','messages.contact_id','contacts.id')
        ->where('messages.church_id',Auth::user()->church_id)
        ->where('status','Deleted')
        ->select('messages.id','contacts.contact_number','messages.updated_at','messages.message')
        ->groupBy('messages.message')
        ->paginate(10);
        return view('after_login.deleted_messages',compact('uncategorized_messages'));

    }

    /**
     * Function to permanently delete a message
     */
    public function permanetlyDeleteMessage(Request $request){
        $message = message::find($request->message_id);
        $message->delete();
        return redirect()->back()->with('message', 'Message was Permanently Deleted Successfully');
    }

    /**
     * Function to search incoming messages
     * 
     */
    protected function searchWithStartDateonly(){
        $messages_to_categories = message::join('category','messages.category_id','category.id')
        ->where('messages.created_at','>=',Date::make($this->message_from)->format('Y-m-d H-i-s'))
        ->where('messages.church_id',Auth::user()->church_id)
        ->orderBy('messages.id','desc')->paginate('10');

        $drop_down_categories = category::where('church_id', Auth::user()->church_id)
        ->select("title", "user_id", "id")->paginate(10);
        return view('after_login.incoming-messages',compact('messages_to_categories','drop_down_categories'));
    }

    protected function searchWithEndDateOnly(){
        $messages_to_categories = message::join('category','messages.category_id','category.id')
        ->where('messages.created_at','<=',Date::make($this->message_to)->format('Y-m-d H-i-s'))
        ->where('messages.church_id',Auth::user()->church_id)
        ->orderBy('messages.id','desc')->paginate('10');

        $drop_down_categories = category::where('church_id', Auth::user()->church_id)
        ->select("title", "user_id", "id")->paginate(10);
        return view('after_login.incoming-messages',compact('messages_to_categories','drop_down_categories'));
    }

    protected function searchWithStartAndEndDates(){
        $messages_to_categories = message::join('category','messages.category_id','category.id')
        ->whereBetween('messages.created_at',
        [Date::make($this->message_from)->format('Y-m-d H-i-s'), Date::make($this->message_to)->format('Y-m-d H-i-s')])
        ->where('messages.church_id',Auth::user()->church_id)
        ->orderBy('messages.id','desc')->paginate('10');

        $drop_down_categories = category::join('category','messages.category_id','category.id')
        ->where('church_id', Auth::user()->church_id)
        ->select("title", "user_id", "id")->paginate(10);
        return view('after_login.incoming-messages',compact('messages_to_categories','drop_down_categories'));
    }

    protected function searchWithCategoryOnly(){
        $messages_to_categories = message::join('category','messages.category_id','category.id')
        ->where('title',$this->search_message)
        ->where('messages.church_id',Auth::user()->church_id)
        ->orderBy('messages.id','desc')->paginate('10');

        $drop_down_categories = category::where('church_id', Auth::user()->church_id)
        ->select("title", "user_id", "id")->paginate(10);
        return view('after_login.incoming-messages',compact('messages_to_categories','drop_down_categories'));
    }

    protected function searchwithStartDateAndCategory(){
        $messages_to_categories = message::join('category','messages.category_id','category.id')
        ->where('title',$this->search_message)
        ->whereBetween('messages.created_at',
        [Date::make($this->message_from)->format('Y-m-d H-i-s'), Date::make($this->message_to)->format('Y-m-d H-i-s')])
        ->where('messages.church_id',Auth::user()->church_id)
        ->orderBy('messages.id','desc')->paginate('10');

        $drop_down_categories = category::where('church_id', Auth::user()->church_id)
        ->select("title", "user_id", "id")->paginate(10);
        return view('after_login.incoming-messages',compact('messages_to_categories','drop_down_categories'));
    }

    protected function searchwithEndDateAndCategory(){
        $messages_to_categories = message::join('category','messages.category_id','category.id')
        ->where('title',$this->search_message)
        ->where('messages.created_at','<=',Date::make($this->message_to)->format('Y-m-d H-i-s'))
        ->where('messages.church_id',Auth::user()->church_id)
        ->orderBy('messages.id','desc')->paginate('10');

        $drop_down_categories = category::where('church_id', Auth::user()->church_id)
        ->select("title", "user_id", "id")->paginate(10);
        return view('after_login.incoming-messages',compact('messages_to_categories','drop_down_categories'));
    }

    protected function searchWithStartEndDatesAndCategory(){
        $messages_to_categories = message::join('category','messages.category_id','category.id')
        ->where('title',$this->search_message)
        ->where('messages.created_at','<=',Date::make($this->message_to)->format('Y-m-d H-i-s'))
        ->where('messages.church_id',Auth::user()->church_id)
        ->orderBy('messages.id','desc')->paginate('10');

        $drop_down_categories = category::where('church_id', Auth::user()->church_id)
        ->select("title", "user_id", "id")->paginate(10);
        return view('after_login.incoming-messages',compact('messages_to_categories','drop_down_categories'));
    }
    public function searchIncomingMessages(Request $request)
    {
        if(!empty($this->message_from) && empty($this->message_to) && empty($this->search_message)){
            return $this->searchWithStartDateonly();
        }
        if(!empty($this->message_to) && empty($this->message_from) && empty($this->search_message)){
            return $this->searchWithEndDateOnly();
        }
        if(!empty($this->message_to) && !empty($this->message_from) && empty($this->search_message)){
            return $this->searchWithEndDateOnly();
        }
        if(empty($this->message_to) && empty($this->message_from) && !empty($this->search_message)){
            return $this->searchWithCategoryOnly();
        }
        if(empty($this->message_to) && !empty($this->message_from) && !empty($this->search_message)){
            return $this->searchwithStartDateAndCategory();
        }
        if(!empty($this->message_to) && empty($this->message_from) && !empty($this->search_message)){
            return $this->searchwithEndDateAndCategory();
        }
        if(!empty($this->message_to) && !empty($this->message_from) && !empty($this->search_message)){
            return $this->searchWithStartEndDatesAndCategory();
        }
        else{
            return redirect()->back();
        }
    }
}
