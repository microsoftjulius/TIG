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

class messages extends Controller {
    public function createAPIMessage(Request $request) {
        $contact_id = Contacts::where('contact_number',$request->contact_number)->value('id');
        if($contact_id){
            $registered_searchTerms = searchTerms::all();
            foreach($registered_searchTerms as $search_term){
                if(strpos($request->message, strtolower($search_term->search_term))){
                    $category_id = searchTerms::where('search_term',strtolower($search_term->search_term))->value('category_id');
                    $message = new message();
                    $message->category_id = $category_id;
                    $message->contact_id  = $contact_id;
                    $message->message     = $request->message;
                    $message->status      = 'Recieved';
                    $message->save();
                    return response()->json([$message, 200]);
                }
            }
                $message = new message();
                $message->category_id = null;
                $message->contact_id  = $contact_id;
                $message->message     = $request->message;
                $message->status      = 'Recieved';
                $message->save();
                return response()->json([$message, 200]);
        }else{
            return response()->json(["The senders number is not registered with our system"]);
        }
    }
    public function search_use_contact_group_attributes(Request $request) {
        $search = $request->search;
        $display_sent_message_details = message::where('created_by', $search)->where('church_id', Auth::user()->church_id)
        ->where('status','!=','Deleted')
        ->paginate('10');
        return view('after_login.sent-messages', compact('display_sent_message_details'));
    }
    public function display_sent_messages() {
        $display_sent_message_details = message::join('users', 'users.id', 'messages.created_by')
        ->where('status','!=','Deleted')
        ->where('users.church_id', Auth::user()->church_id)
        ->distinct('messages.message')
        ->select('messages.id', 'messages.message', 'messages.created_at', 'messages.status', 'users.email')
        ->paginate('10');
        return view('after_login.sent-messages', compact('display_sent_message_details'));
    }
    public function drop_down_groups() {
        $drop_down_groups = Groups::where('church_id', Auth::user()->church_id)->select("group_name", "number_of_contacts", "id")->get();
        return view('after_login.Quicksms', compact('drop_down_groups'));
    }
    public function contact_groups(Request $request) {
        return view('after_login.groups');
    }
    public function search_messages(Request $request) {
        $display_sent_message_details = message::where('message', $request->search_message)->orWhere('message', 'like', '%' . $request->search_message . '%')->where('church_id', Auth::user()->church_id)
        ->where('status','Recieved')
        ->paginate('10');
        return view('after_login.sent-messages', compact('display_sent_message_details'))->with(['search_query' => $request->search_message]);
    }
    public function search_message_categories(Request $request) {
        $category = category::join('users','users.id','category.user_id')->where('title', $request->category)
        ->orWhere('title', 'like', '%' . $request->category . '%')
        ->orWhere('name', 'like', '%' . $request->category . '%')
        ->where('category.church_id', Auth::user()->church_id)->paginate('10');
        return view('after_login.message-categories', compact('category'))
        ->with(['search_query' => $request->search_category]);
    }

    public function show_add_category_blade(){
        return view('after_login.add-message-category');
    }
    public function save_message_category(Request $request) {
        if(category::where('church_id',Auth::user()->church_id)->where('title',$request->category)->exists()){
            return Redirect()->back()->withInput()->withErrors("Message category already registered");
        }
        category::create(array('church_id' => Auth::user()->church_id, 'title' => $request->category,'user_id'=>Auth::user()->id));
        return redirect('/message-categories')->withErrors("Category added successfully");
    }
    public function save_added_search_terms(Request $request) {
        message::create(array('church_id' => Auth::user()->church_id, 'search_term_name' => $request->search_term_name, 'search_terms_list'->$request->search_terms_list));
    }
    public function message_categories_page() {
        $category = category::where('category.church_id', Auth::user()->church_id)
        ->join('users', 'users.id', 'category.user_id')
        ->select('category.id','title', 'name')->paginate('10');
        return view('after_login.message-categories', compact('category'));
    }
    public function show_search_terms(Request $request, $id) {
        $search_terms = searchTerms::join('users','users.id','search_terms.user_id')
        ->where('users.church_id',Auth::user()->church_id)
        ->where('category_id',$id)->get();
        return view('after_login.search-term-table',compact('search_terms'));
    }
    public function save_search_terms(Request $request, $id) {
        //return "true";
        if(empty($request->new_search_term)){
            return redirect()->back()->withErrors("Search term cannot be null");
        }
        if(searchTerms::where('church_id',Auth::user()->church_id)->where('search_term',$request->new_search_term)->exists()){
            return redirect()->back()->withErrors("Search term is already registered, choose another search term");
        }
        searchTerms::create(array(
            'user_id' => Auth::user()->id,
            'church_id' => Auth::user()->church_id,
            'category_id' => $id,
            'search_term' => $request->new_search_term
        ));
        return Redirect()->back()->withInput()->withErrors('Search term added successfully');
    }
    public function deleteSearchTerm($id, Request $request){
        //return $id;
        searchTerms::where('id',$id)->delete();
        return Redirect()->back()->withInput()->withErrors("Search Term was deleted Successfully");
    }

    public function display_message_category_form($id){
        $all_search_terms = searchTerms::join('category','category.id','search_terms.category_id')
        ->join('users','users.id','search_terms.user_id')
        ->where('search_terms.church_id',Auth::user()->church_id)
        ->where('category_id',$id)
        ->select('users.name','category.title','search_terms.*')
        ->paginate(10);
        //$search_term = DB::table('users')
        return view('after_login.search-term-table',compact('all_search_terms'));
    }

    public function edit_message_category(Request $request, $id){
        if(category::where('church_id',Auth::user()->church_id)->where('title',$request->new_category_title)->exists()){
            return redirect()->back()->withinput()->withErrors("Cannot update category to that name since a category with that name already exists");
        }
        category::where('id',$id)
        ->update(
                array('title'=> $request->new_category_title)
        );
        return redirect('/message-categories')->withErrors('Category update was successful ');
    }
    public function show_incoming_messages(Request $request){
        $messages_to_categories = category::join('messages','messages.category_id','category.id')
        ->join('contacts','messages.contact_id','contacts.id')
        ->where('category.church_id',Auth::user()->church_id)
        ->where('status','Recieved')
        ->select('messages.message','category.title','contacts.contact_number','messages.created_at')->paginate('10');
        $drop_down_categories = category::where('church_id', Auth::user()->church_id)
        ->select("title", "user_id", "id")->paginate(10);

        return view('after_login.incoming-messages',compact('messages_to_categories','drop_down_categories'));
    }
    public function display_search_terms(){
        $all_search_terms = searchTerms::all();
        return $all_search_terms;
    }
    
    public function showUnCategorizedMessages(){
        $uncategorized_messages = message::join('contacts','messages.contact_id','contacts.id')
        ->where('category_id',null)
        ->where('status','Recieved')
        ->select('messages.message','messages.id','contacts.contact_number','messages.created_at')->paginate('10');
        return view('after_login.uncategorized_messages',compact('uncategorized_messages'));
    }

    public function deleteUncategorizedMessage($id){
        message::where('id',$id)->update(array(
            'status' => 'Deleted',
            'created_by' => Auth::user()->id
        ));
        return Redirect()->back()->withErrors("Messages was deleted successfully");
    }

    public function showDeletedMessages()
    {
        $uncategorized_messages = message::join('contacts','messages.contact_id','contacts.id')
        ->where('status','Deleted')->paginate(10);
        return view('after_login.deleted_messages',compact('uncategorized_messages'));

    }
    public function searchIncomingMessages(Request $request)
        {
            if(empty($request->from) && empty($request->to)){
                $messages_to_categories = message::join('category','messages.category_id','category.id')
                ->where('title',$request->search_message)->paginate('10');
                $drop_down_categories = category::where('church_id', Auth::user()->church_id)
                ->select("title", "user_id", "id")->paginate(10);
                return view('after_login.incoming-messages',compact('messages_to_categories','drop_down_categories'));
            }
            if(empty($request->from)){
                $messages_to_categories = message::join('category','messages.category_id','category.id')
                ->where('messages.created_at',[Date::make($request->to)->format('Y-m-d H-i-s')])
                ->where('title',$request->search_message)->paginate('10');
                $drop_down_categories = category::where('church_id', Auth::user()->church_id)
                ->select("title", "user_id", "id")->paginate(10);
                return view('after_login.incoming-messages',compact('messages_to_categories','drop_down_categories'));
            }
            if(empty($request->to)){
                $messages_to_categories = message::join('category','messages.category_id','category.id')
                ->where('messages.created_at',[Date::make($request->from)->format('Y-m-d H-i-s')])
                ->where('title',$request->search_message)->paginate('10');
                $drop_down_categories = category::where('church_id', Auth::user()->church_id)
                ->select("title", "user_id", "id")->paginate(10);
                return view('after_login.incoming-messages',compact('messages_to_categories','drop_down_categories'));
            }
            $messages_to_categories = message::join('category','messages.category_id','category.id')
            ->whereBetween('messages.created_at',[Date::make($request->from)->format('Y-m-d H-i-s'), Date::make($request->to)->format('Y-m-d H-i-s')])
            ->where('title',$request->search_message)->paginate('10');
            $drop_down_categories = category::where('church_id', Auth::user()->church_id)
            ->select("title", "user_id", "id")->paginate(10);
            return view('after_login.incoming-messages',compact('messages_to_categories','drop_down_categories'));
        }
}
