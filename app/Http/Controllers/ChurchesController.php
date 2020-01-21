<?php

namespace App\Http\Controllers;

use App\User;
use App\churches;
use App\Contacts;
use App\churchdatabase;
use App\ChurchHostedNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ChurchesController extends Controller
{
    public function __construct(Request $request){
        $this->error_message = new ErrorMessagesController();
        $this->allowed_fileExtensions = ['jpg','png','gif','jpeg','ico'];
        $this->contact_number = $request->hosted_number;
        $this->contacts_format = ['25677','25678','25670','25679','25671','25675','25675',
        '25620','25639','25641'];
        $this->contact_length = 12;
    }
    public function getAllChurches()
    {
        $churches = churchdatabase::join('ChurchHostedNumber','ChurchHostedNumber.church_id','church_databases.id')
        ->where('church_databases.id','>',1)
        ->select('church_databases.*','ChurchHostedNumber.contact_number')
        ->orderBy('church_databases.created_at','Desc')
        ->paginate('10');
        if(auth()->user()->church_id == 1){
            return view('after_login.churches',compact('churches'));
        }else{
            return Redirect()->back();
        }
    }
    public function getChurchUsers($id)
    {
        $all_users_in_this_church = User::where('church_id',$id)->get();
        $all_churches = churchdatabase::where('id',$id)->get('id');
        return view('after_login.create-users',compact('all_churches','all_users_in_this_church'));
    }

    public function addNewChurch(Request $request)
    {
        if(ChurchHostedNumber::where('contact_number',$this->contact_number)->exists()){
            return $this->error_message->numberExistsForChurchError();
        }
        if(!in_array(substr($this->contact_number,0,5),$this->contacts_format)){
            return $this->error_message->allowedContactsErrorMessage();
        }
        if(empty($this->contact_number)) {
            return $this->error_message->emptyPhoneNumber();
        }
        if(strlen($this->contact_number) > $this->contact_length || strlen($this->contact_number) < $this->contact_length){
            return $this->error_message->contactLengthError();
        }
        if(!ctype_digit($this->contact_number)){
            return $this->error_message->alphabeticalCharactersErrorResponse();
        }
        if(preg_match('/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/', $request->church_name)){
            return $this->error_message->churchNameErrorResponse();
        }
        if(churchdatabase::where('church_name',$request->church_name)->exists())
        {
            return Redirect()->back()->withInput()->withErrors('Church Name already Registered');
        }
        if(User::where('email',$request->church_name)->exists()){
            return Redirect()->back()->withInput()->withErrors('User Name Already Taken, Choose a different name');
        }
        if(!empty(request()->logo)){
            if(!in_array(strtolower(request()->logo->getClientOriginalExtension()), $this->allowed_fileExtensions)){
                return $this->error_message->imageExtensionError();
            }
            $filename = time().'.'.request()->logo->getClientOriginalExtension();
            request()->logo->move(public_path('images'), $filename);
        }else{
            $filename = '';
        }
        
        churchdatabase::create(array(
            'church_name'       =>  $request->church_name,
            'database_name'     =>  $request->database_name,
            'database_url'      =>  $request->url,
            'database_password' =>  $request->password,
            'attached_logo'     =>  $filename
        ));
        $church_id = churchdatabase::where('church_name',$request->church_name)->value('id');
        User::create([
            'name'      =>  $request->church_name,
            'email'     =>  strtolower(str_replace(' ', '', $request->church_name)),
            'password'  =>  Hash::make(strtolower(str_replace(' ', '', $request->church_name)) . "123"),
        ]);
        User::where('church_id',null)->update(array(
            'church_id' =>  $church_id,
        ));
        ChurchHostedNumber::create(array(
            'church_id'      => $church_id,
            'contact_number' => $request->hosted_number 
        ));
        //creating the churches properties file

        $my_file = $request->church_name.'.txt';
        $handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file);
        $url = "Url: ".$request->url;
        fwrite($handle, $url);
        $username = "\n UserName: ".$request->church_name;
        fwrite($handle, $username);
        $Password = "\n Password: ".Hash::make($request->password);
        fwrite($handle, $Password);
        return redirect('/groups');
    }

    public function addUserToChurch(Request $request){
        User::create([
            'name'      =>  $request->name,
            'email'     =>  $request->email,
            'password'  =>  Hash::make($request->password),
        ]);
        User::where('church_id',null)->update(array(
            'church_id' =>  $request->church_id,
        ));
        return Redirect()->back()->with('message', 'User has been created Successfully');
    }

    //Edit the Church information
    public function editChurchBackgroudColor(Request $request)
    {
        churchdatabase::where('id',$request->church_id)->update(array(
            'background_color'=>$request->background_color
        ));
        return Redirect()->back()->withInput()->with('message', 'Background Color Edited Successfully');
    }

    //Update church as Active
    public function activateChurch(Request $request, churches $churches)
    {
        churchdatabase::where('id',$request->church_id)->update(array(
            'status'=>'active'
        ));
    }

    //Mark Church as Deleted
    public function destroyChurch(Request $request)
    {
        churchdatabase::where('id',$request->church_id)->update(array(
            'status'=>'deleted'
        ));
    }

    public function search(Request $request){
        $churches  = churchdatabase::where('church_name',$request->church_name)
        ->orWhere('church_name', 'like', '%' . $request->church_name. '%')
        ->paginate('10');

        return view('after_login.churches',compact('churches'))->with([
            'search_query' => $request->church_name
        ]);
    }

    public function view_church_user($id){
        $view_user = User::where('church_id',$id)
        ->join('church_databases','church_databases.id','users.church_id')
        ->paginate('10');
        return view('after_login.church_user',compact('view_user'));
    }
}
