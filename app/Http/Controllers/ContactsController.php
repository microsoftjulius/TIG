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
    public function __construct(Request $request){
        $this->error_message = new ErrorMessagesController();
        $this->contacts_format = ['25677','25678','25670','25679','25671','25675','25675',
        '25620','25639','25641'];
        $this->contact_length = 12;
        $this->contact_number = $request->contact;
        $this->user_name = $request->name;
    }
    public function view_for_group($id, Request $request) {
        if(Auth::user()->id == 1){
            return $this->adminsViewOfContactsForGroup($id);
        }else{
            return $this->usersViewOfContactsForGroup($id);
        }
    }
    public function save_contact_to_group(Request $request, $id){
        if(Contacts::where('group_id',$id)->where('contact_number',$this->contact_number)->exists()){
            return $this->error_message->numberExistsError();
        }
        if(empty($this->contact_number)) {
            return $this->error_message->emptyPhoneNumber();
        }
        if(!in_array(substr($this->contact_number,0,5),$this->contacts_format)){
            return $this->error_message->allowedContactsErrorMessage();
        }
        if(strlen($this->contact_number) > $this->contact_length || strlen($this->contact_number) < $this->contact_length){
            return $this->error_message->contactLengthError();
        }
        if(!ctype_digit($this->contact_number)){
            return $this->error_message->alphabeticalCharactersErrorResponse();
        }
        else{
            return $this->addContactToGroup($id);
        }
    }
    public function deleteContact($contact_id){
        $group_id = Contacts::where('id',$contact_id)->value('group_id');
        $deleted_contact = Contacts::find($contact_id)->delete();
        Groups::find($group_id)->update(array('number_of_contacts'=>Contacts::where('group_id',$group_id)->count()));
        return $this->error_message->numberDeletedSuccessfully();
    }
    protected function addContactToGroup($id){
        $contact = new Contacts();
        $contact->church_id = Auth::user()->church_id;
        $contact->group_id = $id;
        $contact->u_name = $this->user_name;
        $contact->created_by = Auth::user()->id;
        $contact->update_by = Auth::user()->id;
        $contact->contact_number = $this->contact_number;
        $contact->save();
        Groups::find($id)->update(array('number_of_contacts'=>Contacts::where('group_id',$id)->count()));
        return $this->error_message->numberCreatedSuccessfully();
    }
    protected function adminsViewOfContactsForGroup($id){
        $contacts = Contacts::join('Groups', 'contacts.group_id', 'Groups.id')
        ->join('church_databases', 'church_databases.id', 'contacts.church_id')
        ->join('users', 'users.id', 'contacts.created_by')
        ->where('group_id',$id)
        ->select('contacts.contact_number','users.name','Groups.group_name','users.email','contacts.id','contacts.u_name')
        ->orderBy('id','Desc')
        ->paginate(10);
        return view('after_login.contacts', compact('contacts'));
    }
    protected function usersViewOfContactsForGroup($id){
        $contacts = Contacts::join('Groups', 'contacts.group_id', 'Groups.id')
        ->join('church_databases', 'church_databases.id', 'contacts.church_id')
        ->join('users', 'users.id', 'contacts.created_by')
        ->where('contacts.church_id',Auth::user()->church_id)
        ->where('contacts.group_id',$id)
        ->select('contacts.contact_number','users.name','Groups.group_name','users.email','contacts.id','contacts.u_name')
        ->paginate(10);
        return view('after_login.contacts', compact('contacts'));
    }
}
