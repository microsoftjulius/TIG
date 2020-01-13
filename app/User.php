<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','role_id','church_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function count_groups(){
        $count = churchdatabase::get()->count();
        return $count;
    }

    public function count_users_in_a_group(){
        $count = User::where('church_id',Auth::user()->id)->get()->count();
        return $count;
    }

    public function count_registered_contacts(){
        $count = User::where('church_id',"=",Auth::user()->id)->get()->count();
        return $count;
    }

    public function count_contacts_in_a_groups(){
        $count = Contacts::where('contact_number',"=",Auth::user()->id)->get()->count();
        return $count;
    }
    
    public function getLoggedInChurchLogo(){
        $church_logo = churchdatabase::where('id',Auth::user()->church_id)->value('attached_logo');
        if(empty($church_logo)){
            $church_logo = 'pahappa.png';
        }
        return $church_logo;
    }
}
