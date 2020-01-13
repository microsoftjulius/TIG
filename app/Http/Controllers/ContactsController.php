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
        $this->special_characters = ['~','`','@','!','#','$','%','^','&','*','(',')','"',';',':','.',',','?','/','=','+',"'"];
        $this->contact_length = 12;
        $this->alphabetic_letters = array_merge(range('A', 'Z'), range('a', 'z'));
        $this->contact_number = $request->contact;
        $this->user_name = $request->name;
        $this->group_id = 88;
    }
    protected function addContactToGroup(){
        $contact = new Contacts();
        $contact->church_id = 1;
        $contact->group_id = $this->group_id;
        $contact->u_name = $this->user_name;
        $contact->created_by = 1;
        $contact->update_by = 1;
        $contact->contact_number = $this->contact_number;
        $contact->save();
        Groups::find($this->group_id)->update(array('number_of_contacts'=>Contacts::where('group_id',$this->group_id)->count()));
        //return Redirect()->back()->withErrors('Contact has been created successfully');
        return "Contact created";
    }
    public function view_for_group(Request $request) {
        if(Auth::user()->id == 1){
            $contacts = Contacts::join('Groups', 'contacts.group_id', 'Groups.id')
            ->join('church_databases', 'church_databases.id', 'contacts.church_id')
            ->join('users', 'users.id', 'contacts.created_by')
            ->where('group_id',$this->group_id)
            ->select('contacts.contact_number','users.name','Groups.group_name','users.email','contacts.id','contacts.u_name')
            ->orderBy('id','Desc')
            ->paginate(10);
        }else{
            $contacts = Contacts::join('Groups', 'contacts.group_id', 'Groups.id')
            ->join('church_databases', 'church_databases.id', 'contacts.church_id')
            ->join('users', 'users.id', 'contacts.created_by')
            ->where('contacts.church_id',Auth::user()->church_id)
            ->where('contacts.group_id',$this->group_id)
            ->select('contacts.contact_number','users.name','Groups.group_name','users.email','contacts.id','contacts.u_name')
            ->paginate(10);
        }
        return view('after_login.contacts', compact('contacts'));
    }
    public function save_contact_to_group() {
        if(Contacts::where('church_id',1)->where('contact_number',$this->contact_number)->where('group_id',$this->group_id)->exists()){
            //return redirect()->back()->withInput()->withErrors("Supplied number already exists or it is registered under another group");
            return "Supplied number already exists or it is registered under another group";
        } //-- passed
        if (empty($this->contact_number)) {
            //return Redirect()->back()->withErrors("Contact information cannot be null");
            return "Contact information cannot be null";
        }
        for($i=0; $i<= count($this->alphabetic_letters); $i++){
            if(in_array($i, explode(' ', $this->contact_number)) == true){
                //return $this->error_message->alphabeticalCharactersErrorResponse();
                return "Phone number cannot contain Alphabetical letters";
            }else{
                for($j=0; $j <= count($this->special_characters); $j++){
                    if(in_array($j, explode(' ', $this->contact_number)) == true) {
                        return $this->error_message->specialCharactersErrorResponse();
                    } 
                }
            }
        }
        if(strlen($this->contact_number) > 12 || strlen($this->contact_number) > 12){
            return $this->error_message->contactLengthError();
        }
        if(in_array($this->contacts_format,substr($this->contact_number,0,5))){
            return $this->error_message->allowedContactsErrorMessage();
        }
        if(Contacts::where('contact_number',$this->contact_number)->where('church_id',Auth::user()->id)->exists()){
            return redirect()->back()->withInput()->withErrors('The supplied contact is already registered under a certain group, please add another contact');
        }
        else{
            return $this->addContactToGroup();
        }
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
