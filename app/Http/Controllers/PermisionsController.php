<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\roles;
use DB;
use Auth;
use App\permissionroles; 

class PermisionsController extends Controller
{
    public function rolesAndPermisionsView(){
        if(in_array('Can create user permissions',auth()->user()->getUserPermisions())){
            $roles = DB::table('roles')->where('church_id',Auth::user()->church_id)
            // ->join('permisions_roles','permisions_roles.role_id','roles.id')
            // ->select('roles.*',DB::raw('COUNT(permisions_roles.role_id) as countRoles'))
            // ->groupBy('roles.role_name')
            ->paginate(10);
            $permissions = DB::table('permisions')
            ->paginate(100);
            return view('after_login.permisions',compact('roles','permissions'));
        }else{
            return redirect()->back();
        }
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
                if(permissionroles::where('role_id',$id)->where('permision_id',$permission)->exists()){
                    continue;
                }
                else{
                    //return $permission;
                    permissionroles::create(array(
                        'role_id' => $id,
                        'permision_id' => $permission,
                        'user_id'       => Auth::user()->id,
                        'created_by'    => Auth::user()->id,
                    ));
                }
            }
        return Redirect()->back()->withErrors("Permission(s) added Successfully");
    }
}
