<?php

namespace App\Http\Controllers;

use App\User;
use App\churches;
use App\Contacts;
use App\churchdatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ChurchesController extends Controller
{
    public function __construct(){
        $this->error_message = new ErrorMessagesController();
        $this->allowed_fileExtensions = ['jpg','png','gif','jpeg','ico'];
    }
    public function getAllChurches()
    {
        $churches = churchdatabase::where('id','>',1)
        ->orderBy('created_at','Desc')
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
        return Redirect()->back()->withInput()->withErrors('User Created Successfully');
    }

    //Edit the Church information
    public function editChurchBackgroudColor(Request $request)
    {
        churchdatabase::where('id',$request->church_id)->update(array(
            'background_color'=>$request->background_color
        ));
        return Redirect()->back()->withInput()->withErrors('Background Color Edited Successfully');
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
