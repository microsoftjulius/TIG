<?php

namespace App\Http\Controllers;

use App\Groups;
use App\Contacts;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class GroupsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     //It redirects to a page showing all contacts
    public function index()
    {
    $contacts = Groups::join('church_databases','church_databases.id','Groups.church_id')
    ->join('users','users.id','Groups.created_by')
    ->where('users.church_id',Auth::user()->church_id)
    ->select('Groups.group_name','users.email','Groups.id','Groups.created_at','Groups.number_of_contacts')
    ->paginate('10');

    $counted = Groups::join('church_databases','church_databases.id','Groups.church_id')
    ->join('users','users.id','Groups.created_by')
    ->join('contacts','contacts.group_id','Groups.id')
    ->where('users.church_id',Auth::user()->church_id)
    ->select('Groups.group_name','users.email','Groups.id')->count();
    return view('after_login.contacts-groups',compact('contacts','counted'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_group(Request $request)
    {
        if(empty($request->group_name)){
            return Redirect()->back()->withInput()->withErrors("Group name cannot be empty");
        }
        if(Groups::where('church_id',Auth::user()->church_id)->where('group_name',$request->group_name)
        ->exists()){
            return Redirect()->back()->withInput()->withErrors('Group Already Exists, Kindly Create a new Group');
            // $group_id = Groups::max('id');
            // return $group_id;
        }
        Groups::create(array(
            'group_name'      =>$request->group_name,
            'church_id' => Auth::user()->church_id,
            'created_by' => Auth::user()->id
        ));
        $group_id = Groups::where('church_id',Auth::user()->church_id)->max('id');
        Contacts::create(array(
            'church_id' => Auth::user()->church_id,
            'group_id'  => $group_id,
            'created_by' => Auth::user()->id,
            'update_by' => Auth::user()->id,
            'contact_number' => '[{"Contact":"","name":""}]'
        ));
        return redirect('/contact-groups');
    }

    public function search_group(Request $request)
    {
        $contacts = Groups::join('church_databases','church_databases.id','Groups.church_id')
        ->join('users','users.id','Groups.created_by')
        ->where('Groups.group_name',$request->group_name)
        ->orWhere('users.email',$request->group_name)
        ->orWhere('Groups.group_name', 'like', '%' . $request->group_name. '%')
        ->where('users.church_id',Auth::user()->church_id)
        ->select('Groups.group_name','users.email','Groups.id','Groups.created_at')
        ->paginate('10');

        $counted = Groups::join('church_databases','church_databases.id','Groups.church_id')
        ->join('users','users.id','Groups.created_by')
        ->join('contacts','contacts.group_id','Groups.id')
        ->where('users.church_id',Auth::user()->church_id)
        ->select('Groups.group_name','users.email','Groups.id')->count();
        return view('after_login.contacts-groups',compact('counted','contacts'))->with([
            'search_query' => $request->group_name
        ]);
    }

    public function show_form(){
        return view('after_login.add-group');
    }
}
