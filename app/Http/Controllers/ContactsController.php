<?php
namespace App\Http\Controllers;
use App\Contacts;
use App\Exports\ContactsExport;
use App\Groups;
use App\Imports\ContactsImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;
class ContactsController extends Controller {
    public function __construct(){
        $this->error_message = new ErrorMessagesController();
    }
    public function view_for_group($id, Request $request) {
        if(Auth::user()->id == 1){
            $contacts = Contacts::join('Groups', 'contacts.group_id', 'Groups.id')
            ->join('church_databases', 'church_databases.id', 'contacts.church_id')
            ->join('users', 'users.id', 'contacts.created_by')
            ->where('group_id',$id)
            ->select('contacts.contact_number','users.name','Groups.group_name','users.email','contacts.id','contacts.u_name')
            ->orderBy('id','Desc')
            ->paginate(10);
        }else{
            $contacts = Contacts::join('Groups', 'contacts.group_id', 'Groups.id')
            ->join('church_databases', 'church_databases.id', 'contacts.church_id')
            ->join('users', 'users.id', 'contacts.created_by')
            ->where('contacts.church_id',Auth::user()->church_id)
            ->where('contacts.group_id',$id)
            ->select('contacts.contact_number','users.name','Groups.group_name','users.email','contacts.id','contacts.u_name')
            ->paginate(10);
        }
        return view('after_login.contacts', compact('contacts'));
    }
    public function save_contact_to_group($id, Request $request) {
        if(Contacts::where('church_id',Auth::user()->church_id)
        ->where('contact_number',$request->contact)->exists()){
            return redirect()->back()->withInput()->withErrors("Supplied number already exists or it is registered under another group");
        }
        if (empty($request->contact)) {
            return Redirect()->back()->withErrors("Contact information cannot be null");
        }
        if (ctype_alpha($request->contact)) {
            return $this->error_message->errorResponse();
        }
        if  (preg_match('/[a-zA-Z]+$/', $request->contact)) {
            return Redirect()->back()->withInput()->withErrors("Please input a correct number, it should not be alpha numeric");
        }
        if (strpos($request->contact, '.') == true) {
            return $this->error_message->errorResponse();
        } elseif (strpos($request->contact, '!') == true) {
            return $this->error_message->errorResponse();
        } elseif (strpos($request->contact, '@') == true) {
            return $this->error_message->errorResponse();
        } elseif (strpos($request->contact, '#') == true) {
            return $this->error_message->errorResponse();
        } elseif (strpos($request->contact, '$') == true) {
            return $this->error_message->errorResponse();
        } elseif (strpos($request->contact, '%') == true) {
            return $this->error_message->errorResponse();
        } elseif (strpos($request->contact, '^') == true) {
            return $this->error_message->errorResponse();
        } elseif (strpos($request->contact, '&') == true) {
            return $this->error_message->errorResponse();
        } elseif (strpos($request->contact, '*') == true) {
            return $this->error_message->errorResponse();
        } elseif (strpos($request->contact, '"') == true) {
            return $this->error_message->errorResponse();
        } elseif (strpos($request->contact, ',') == true) {
            return $this->error_message->errorResponse();
        } elseif (strpos($request->contact, ':') == true) {
            return $this->error_message->errorResponse();
        } elseif (strpos($request->contact, '\'') == true) {
            return $this->error_message->errorResponse();
        } elseif (strpos($request->contact, '?') == true) {
            return $this->error_message->errorResponse();
        } elseif (strpos($request->contact, ';') == true) {
            return $this->error_message->errorResponse();
        } elseif (strpos($request->contact, '/') == true) {
            return $this->error_message->errorResponse();
        } elseif (strpos($request->contact, '}') == true) {
            return $this->error_message->errorResponse();
        } elseif (strpos($request->contact, '{') == true) {
            return $this->error_message->errorResponse();
        } elseif (strpos($request->contact, '[') == true) {
            return $this->error_message->errorResponse();
        } elseif (strpos($request->contact, ']') == true) {
            return $this->error_message->errorResponse();
        } elseif (strpos($request->contact, '-') == true) {
            return $this->error_message->errorResponse();
        } elseif (strpos($request->contact, '_') == true) {
            return $this->error_message->errorResponse();
        } elseif (strpos($request->contact, '=') == true) {
            return $this->error_message->errorResponse();
        } elseif (strpos($request->contact, '+') == true) {
            return $this->error_message->errorResponse();
        } elseif (strpos($request->contact, '(') == true) {
            return $this->error_message->errorResponse();
        } elseif (strpos($request->contact, ')') == true) {
            return $this->error_message->errorResponse();
        } elseif (strlen($request->contact) > 12) {
            return $this->error_message->errorResponse();
        } elseif (strlen($request->contact) < 12) {
            return $this->error_message->errorResponse();
        } elseif ($request->contact[0] != 2) {
            return $this->error_message->errorResponse();
        } elseif ($request->contact[1] != 5) {
            return $this->error_message->errorResponse();
        } elseif ($request->contact[2] != 6) {
            return $this->error_message->errorResponse();
        }
        elseif ($request->contact[2] != 6) {
            return $this->error_message->errorResponse();
        }elseif ($request->contact[3] != 7) {
            return $this->error_message->errorResponse();
        }
        if(Contacts::where('contact_number',$request->contact)->where('church_id',Auth::user()->id)->exists()){
            return redirect()->back()->withInput()->withErrors('The supplied contact is already registered under a certain group, please add another contact');
        }
        $contact = new Contacts();
        $contact->church_id = Auth::user()->church_id;
        $contact->group_id = $id;
        $contact->u_name = $request->name;
        $contact->created_by = Auth::user()->id;
        $contact->update_by = Auth::user()->id;
        $contact->contact_number = $request->contact;
        $contact->save();
        Groups::find($id)->update(array('number_of_contacts'=>Contacts::where('group_id',$id)->count()));
        return Redirect()->back()->withErrors('Contact has been created successfully');
    }
    public function deleteContact($contact_id) {
        $group_id = Contacts::where('id',$contact_id)->value('group_id');
        $deleted_contact = Contacts::find($contact_id)->delete();
        Groups::find($group_id)->update(array('number_of_contacts'=>Contacts::where('group_id',$group_id)->count()));
        return Redirect()->back()->withInput()->withErrors("Contact was deleted Successfully");
    }
    public function import() {
        Excel::import(new ContactsImport, request()->file('file'));
        return back();
    }
    public function export() {
        return Excel::download(new ContactsExport, 'contacts.xlsx');
    }
}
