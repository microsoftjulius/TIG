<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\church_user;
use Illuminate\Support\Facades\Auth;
class ChurchUserController extends Controller {
    public function __construct(){
        $this->error_message = new ErrorMessagesController();
    }
    public function index(Request $request) {
        $display_all_church_users = User::Where('email', $request->search)
        ->orWhere('name', 'like', '%' . $request->search . '%')
        ->where('church_id', Auth::user()->church_id)->paginate('10');
        return view('after_login.users', compact('display_all_church_users'))->with(['search_query' => $request->search]);
    }
    public function store(Request $request) {
        if (empty($request->username)) {  return Redirect()->back();
        }
        if (ctype_alpha($request->username)) {
            return $this->error_message->errorResponse();
        }
        if(preg_match('/[a-zA-Z]+$/',$request->username)){
            return $this->error_message->errorResponse();
        }
        if (strpos($request->username, '.') == true) {
            return $this->error_message->errorResponse();
        } elseif (strpos($request->username, '!') == true) {
            return $this->error_message->errorResponse();
        } elseif (strpos($request->username, '@') == true) {
            return $this->error_message->errorResponse();
        } elseif (strpos($request->username, '#') == true) {
            return $this->error_message->errorResponse();
        } elseif (strpos($request->username, '$') == true) {
            return $this->error_message->errorResponse();
        } elseif (strpos($request->username, '%') == true) {
            return $this->error_message->errorResponse();
        } elseif (strpos($request->username, '^') == true) {
            return $this->error_message->errorResponse();
        } elseif (strpos($request->username, '&') == true) {
            return $this->error_message->errorResponse();
        } elseif (strpos($request->username, '*') == true) {
            return $this->error_message->errorResponse();
        } elseif (strpos($request->username, '"') == true) {
            return $this->error_message->errorResponse();
        } elseif (strpos($request->username, ',') == true) {
            return $this->error_message->errorResponse();
        } elseif (strpos($request->username, ':') == true) {
            return $this->error_message->errorResponse();
        } elseif (strpos($request->username, '\'') == true) {
            return $this->error_message->errorResponse();
        } elseif (strpos($request->username, '?') == true) {
            return $this->error_message->errorResponse();
        } elseif (strpos($request->username, ';') == true) {
            return $this->error_message->errorResponse();
        } elseif (strpos($request->username, '/') == true) {
            return $this->error_message->errorResponse();
        } elseif (strpos($request->username, '}') == true) {
            return $this->error_message->errorResponse();
        } elseif (strpos($request->username, '{') == true) {
            return $this->error_message->errorResponse();
        } elseif (strpos($request->username, '[') == true) {
            return $this->error_message->errorResponse();
        } elseif (strpos($request->username, ']') == true) {
            return $this->error_message->errorResponse();
        } elseif (strpos($request->username, '-') == true) {
            return $this->error_message->errorResponse();
        } elseif (strpos($request->username, '_') == true) {
            return $this->error_message->errorResponse();
        } elseif (strpos($request->username, '=') == true) {
            return $this->error_message->errorResponse();
        } elseif (strpos($request->username, '+') == true) {
            return $this->error_message->errorResponse();
        } elseif (strpos($request->username, '(') == true) {
            return $this->error_message->errorResponse();
        } elseif (strpos($request->username, ')') == true) {
            return $this->error_message->errorResponse();
        } elseif (strlen($request->username) > 12) {
            return $this->error_message->errorResponse();
        } elseif (strlen($request->username) < 12) {
            return $this->error_message->errorResponse();
        } elseif ($request->username[0] != 2) {
            return $this->error_message->errorResponse();
        } elseif ($request->username[1] != 5) {
            return $this->error_message->errorResponse();
        } elseif ($request->username[2] != 6) {
            return $this->error_message->errorResponse();
        }elseif ($request->username[3] != 7) {
            return $this->error_message->errorResponse();
        }

        if (User::where('email', $request->username)->exists()) {
            return Redirect()->back()->withInput()->withErrors('Username already taken, kindly choose another username');
        }
        User::create(array('name' => $request->first_name . " " . $request->last_name, 'email' => $request->username, 'password' => Hash::make($request->password), 'church_id' => Auth::user()->church_id));
        return redirect('/user');
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
                return Redirect()->back()->withInput()->withErrors("Password update was successful");
            } else {
                return Redirect()->back()->withInput()->withErrors("Incorrect password has been supplied");
            }
        } else {
            return Redirect()->back()->withInput()->withErrors("Make sure the two new passwords match");
        }
    }
    public function show() {
        $display_all_church_users = User::where('church_id', Auth::user()->church_id)->paginate('10');
        return view('after_login.users', compact('display_all_church_users'));
    }

}
