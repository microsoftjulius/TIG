<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\church_user;
use Illuminate\Support\Facades\Auth;
use DB;

class ChurchUserController extends Controller {
    public function __construct(Request $request){
        $this->error_message = new ErrorMessagesController();
        $this->contacts_format = ['25677','25678','25670','25679','25671','25675','25675',
        '25620','25639','25641'];
        $this->contact_length = 12;
        $this->contact_number = $request->username;
        $this->first_name = $request->first_name;
        $this->last_name = $request->last_name;
        $this->password = $request->password;
    }
    public function index(Request $request) {
        $display_all_church_users = User::Where('email', $request->search)
        ->orWhere('name', 'like', '%' . $request->search . '%')
        ->where('church_id', Auth::user()->church_id)->paginate('10');
        return view('after_login.users', compact('display_all_church_users'))->with(['search_query' => $request->search]);
    }
    public function store(Request $request) 
    {
        if(empty($this->contact_number)) {
            return $this->error_message->emptyPhoneNumber();
        }
        if(strlen($this->contact_number) > $this->contact_length || strlen($this->contact_number) < $this->contact_length){
            return $this->error_message->contactLengthError();
        }
        if(!ctype_digit($this->contact_number)){
            return $this->error_message->alphabeticalCharactersErrorResponse();
        }
        if(!in_array(substr($this->contact_number,0,5),$this->contacts_format)){
            return $this->error_message->allowedContactsErrorMessage();
        }
        if (User::where('email', $this->contact_number)->exists()) {
            return Redirect()->back()->withInput()->withErrors('Username already taken, kindly choose another username');
        }else{
            return $this->addUserToChurch();
        }
    }

    public function display_user_password() {
        $display = User::where('church_id', auth()->user()->church_id)->get();
        return view('after_login.view-passwords', compact('display'));
    }
    public function store_users_password(Request $request) {
        $get_users_current_password = User::find(Auth::user()->id)->password;
        $current_password = $request->current_password;
        if ($request->new_password == $request->confirm_password) {
            if (Hash::check($current_password, $get_users_current_password)) {
                User::where("id", Auth::user()->id)->update(array('password' => Hash::make($request->new_password)));
                Auth::logout();
                return Redirect()->back()->with('message', 'Password was Updated successfully');
            } else {
                return Redirect()->back()->withInput()->withErrors("Incorrect password has been supplied");
            }
        } else {
            return Redirect()->back()->withInput()->withErrors("Make sure the two new passwords match");
        }
    }
    public function show() {
        $display_all_church_users = User::where('users.church_id', Auth::user()->church_id)
        // ->join('permisions_roles','permisions_roles.id','users.id')
        // ->join('roles','permisions_roles.role_id','roles.id')
        // ->select('users.*','roles.role_name')
        ->paginate('10');
        return view('after_login.users', compact('display_all_church_users'));
    }

    protected function addUserToChurch(){
        
        $role_id = DB::table('roles')->where('church_id',Auth::user()->church_id)->where('role_name',request()->role)->value('id');
        if(empty($role_id)){
            return redirect()->back()->withErrors("Create a role to continue");
        }
        User::create(array('name' => $this->first_name . " " . $this->last_name,
        'email' => $this->contact_number, 
        'password' => Hash::make($this->password), 
        'church_id' => Auth::user()->church_id,
        'role_id'   => $role_id));
        return redirect('/user');
    }
}
