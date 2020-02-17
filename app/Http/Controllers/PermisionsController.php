<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\roles;
use DB;
use Auth; 

class PermisionsController extends Controller
{
    public function rolesAndPermisionsView(){
        $roles = DB::table('roles')->where('church_id',Auth::user()->church_id)->get();
        $permissions = DB::table('permisions')->get();
        return view('after_login.permisions',compact('roles','permissions'));
    }
    public function createRole(){
        roles::create(array(
            'role_name' => request()->role,
            'church_id' => Auth::user()->church_id,
        ));
        return redirect()->back()->with('message','New role has been created successfully');
    }
    public function assignRoles($id, Request $request){
        if(empty($request->user_permisions)){
            return redirect()->back()->withErrors("No updates were made, you didn't select any permision");
        }
        $permissions = $request->user_permisions;
            foreach($permissions as $permission){
                if(permisionroles::where('role_id',$id)->where('permision_id',$permission)->exists()){
                    continue;
                }
                else{
                    permisionroles::create(array(
                        'role_id' => $id,
                        'permision_id' => $permission
                    ));
                }
            }
        return Redirect()->back()->withErrors("Permission(s) added Successfully");
    }
}
