<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use DB;
use App\SendersNumber;
use App\messages;
use App\category;

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
        return $count-1;
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
    public function getClientsRegisteredMonths(){
        $months_array = [];
        $employees = messages::whereYear('created_at', date('Y'))
        ->where('transaction_status','SUCCESSFUL')
        ->select(DB::raw('MONTHNAME(created_at) month'))
        ->orderBy('month', 'Asc')
        ->groupBy('month')
        ->get();
        foreach($employees as $employe){
            array_push($months_array, $employe->month);
        }
        $months_array = ["January","February","March","April","May","June","July","August","September","October","November","December"];
        return $months_array;
    }

    public function countScheduledMessages(){
        $scheduled_messages = messages::where('status','Scheduled')->get()->count();
        return $scheduled_messages;
    }
    public function countFailedMessages(){
        $failed_messages = messages::where('status','Failed')->get()->count();
        return $failed_messages;
    }
    public function getJanuaryRequests(){
        $count = CustomerRequests::whereYear('created_at', date('Y'))->where(DB::raw("(MONTHNAME(created_at))"),"January")->get()->count();
        return $count;
    }
    public function getFebrauryRequests(){
        $count = CustomerRequests::whereYear('created_at', date('Y'))->where(DB::raw("(MONTHNAME(created_at))"),"February")->get()->count();
        return $count;
    }
    public function getMarchRequests(){
        $count = CustomerRequests::whereYear('created_at', date('Y'))->where(DB::raw("(MONTHNAME(created_at))"),"March")->get()->count();
        return $count;
    }
    public function getAprilRequests(){
        $count = CustomerRequests::whereYear('created_at', date('Y'))->where(DB::raw("(MONTHNAME(created_at))"),"April")->get()->count();
        return $count;
    }
    public function getMayRequests(){
        $count = CustomerRequests::whereYear('created_at', date('Y'))->where(DB::raw("(MONTHNAME(created_at))"),"May")->get()->count();
        return $count;
    }
    public function getJuneRequests(){
        $count = CustomerRequests::whereYear('created_at', date('Y'))->where(DB::raw("(MONTHNAME(created_at))"),"June")->get()->count();
        return $count;
    }
    public function getJulyRequests(){
        $count = CustomerRequests::whereYear('created_at', date('Y'))->where(DB::raw("(MONTHNAME(created_at))"),"July")->get()->count();
        return $count;
    }
    public function getAugustRequests(){
        $count = CustomerRequests::whereYear('created_at', date('Y'))->where(DB::raw("(MONTHNAME(created_at))"),"August")->get()->count();
        return $count;
    }
    public function getSeptemberRequests(){
        $count = CustomerRequests::whereYear('created_at', date('Y'))->where(DB::raw("(MONTHNAME(created_at))"),"September")->get()->count();
        return $count;
    }
    public function getOctoberRequests(){
        $count = CustomerRequests::whereYear('created_at', date('Y'))->where(DB::raw("(MONTHNAME(created_at))"),"October")->get()->count();
        return $count;
    }
    public function getNovemberRequests(){
        $count = CustomerRequests::whereYear('created_at', date('Y'))->where(DB::raw("(MONTHNAME(created_at))"),"November")->get()->count();
        return $count;
    }
    public function getDecemberRequests(){
        $count = CustomerRequests::whereYear('created_at', date('Y'))->where(DB::raw("(MONTHNAME(created_at))"),"December")->get()->count();
        return $count;
    }

    public function getCountOfGamesWithWorkers(){
        $games = messages::join('games','games.id','employees.game_id')->where('employees.status','active')->count();
        $games_all = DB::table('games')->count();
        return (($games/$games_all)*100);
    }

    public function getCountOfGamesWithNoWorkers(){
        $games_all = DB::table('games')->count();
        return (100-$this->getCountOfGamesWithWorkers());
    }

    public function getSubscribersInJanuary(){
        if(Auth::user()->church_id == 1){
        $count = SendersNumber::whereYear('created_at', date('Y'))->where(DB::raw("(MONTHNAME(created_at))"),"January")
        ->where('category_id','!=',null)
        ->get()->count();
        }else{
        $count = SendersNumber::whereYear('created_at', date('Y'))->where(DB::raw("(MONTHNAME(created_at))"),"January")
        ->where('category_id','!=',null)->where('church_id',Auth::user()->church_id)
        ->get()->count();
        }
        return $count;
    }
    public function getSubscribersInFebruary(){
        if(Auth::user()->church_id == 1){
        $count = SendersNumber::whereYear('created_at', date('Y'))->where(DB::raw("(MONTHNAME(created_at))"),"February")
        ->where('category_id','!=',null)
        ->get()->count();
        }else{
        $count = SendersNumber::whereYear('created_at', date('Y'))->where(DB::raw("(MONTHNAME(created_at))"),"February")
        ->where('category_id','!=',null)->where('church_id',Auth::user()->church_id)
        ->get()->count();
        }
        return $count;
    }
    public function getSubscribersInMarch(){
        if(Auth::user()->church_id == 1){
        $count = SendersNumber::whereYear('created_at', date('Y'))->where(DB::raw("(MONTHNAME(created_at))"),"March")
        ->where('category_id','!=',null)
        ->get()->count();
        }else{
        $count = SendersNumber::whereYear('created_at', date('Y'))->where(DB::raw("(MONTHNAME(created_at))"),"March")
        ->where('category_id','!=',null)->where('church_id',Auth::user()->church_id)
        ->get()->count();
        }
        return $count;
    }
    public function getSubscribersInApril(){
        if(Auth::user()->church_id == 1){
        $count = SendersNumber::whereYear('created_at', date('Y'))->where(DB::raw("(MONTHNAME(created_at))"),"April")
        ->where('category_id','!=',null)
        ->get()->count();
        }else{
        $count = SendersNumber::whereYear('created_at', date('Y'))->where(DB::raw("(MONTHNAME(created_at))"),"April")
        ->where('category_id','!=',null)->where('church_id',Auth::user()->church_id)
        ->get()->count();
        }
        return $count;
    }
    public function getSubscribersInMay(){
        if(Auth::user()->church_id == 1){
        $count = SendersNumber::whereYear('created_at', date('Y'))->where(DB::raw("(MONTHNAME(created_at))"),"May")
        ->where('category_id','!=',null)->get()->count();
        }else{
        $count = SendersNumber::whereYear('created_at', date('Y'))->where(DB::raw("(MONTHNAME(created_at))"),"May")
        ->where('category_id','!=',null)->where('church_id',Auth::user()->church_id)
        ->get()->count();
        }
        return $count;
    }
    public function getSubscribersInJune(){
        if(Auth::user()->church_id == 1){
        $count = SendersNumber::whereYear('created_at', date('Y'))->where(DB::raw("(MONTHNAME(created_at))"),"June")
        ->where('category_id','!=',null)
        ->get()->count();
        }else{
        $count = SendersNumber::whereYear('created_at', date('Y'))->where(DB::raw("(MONTHNAME(created_at))"),"June")
        ->where('category_id','!=',null)->where('church_id',Auth::user()->church_id)
        ->get()->count();
        }
        return $count;
    }
    public function getSubscribersInjuly(){
        if(Auth::user()->church_id == 1){
        $count = SendersNumber::whereYear('created_at', date('Y'))->where(DB::raw("(MONTHNAME(created_at))"),"July")
        ->where('category_id','!=',null)->get()->count();
        }else{
        $count = SendersNumber::whereYear('created_at', date('Y'))->where(DB::raw("(MONTHNAME(created_at))"),"July")
        ->where('category_id','!=',null)->where('church_id',Auth::user()->church_id)->get()->count();
        }
        return $count;
    }
    public function getSubscribersInAugust(){
        if(Auth::user()->church_id == 1){
        $count = SendersNumber::whereYear('created_at', date('Y'))->where(DB::raw("(MONTHNAME(created_at))"),"August")
        ->where('category_id','!=',null)->get()->count();
        }else{
        $count = SendersNumber::whereYear('created_at', date('Y'))->where(DB::raw("(MONTHNAME(created_at))"),"August")
        ->where('category_id','!=',null)->where('church_id',Auth::user()->church_id)
        ->get()->count();
        }
        return $count;
    }
    public function getSubscribersInSeptember(){
        if(Auth::user()->church_id == 1){
        $count = SendersNumber::whereYear('created_at', date('Y'))->where(DB::raw("(MONTHNAME(created_at))"),"September")
        ->where('category_id','!=',null)
        ->get()->count();
        }else{
        $count = SendersNumber::whereYear('created_at', date('Y'))->where(DB::raw("(MONTHNAME(created_at))"),"September")
        ->where('category_id','!=',null)->where('church_id',Auth::user()->church_id)
        ->get()->count();
        }
        return $count;
    }
    public function getSubscribersInOctober(){
        if(Auth::user()->church_id == 1){
        $count = SendersNumber::whereYear('created_at', date('Y'))->where(DB::raw("(MONTHNAME(created_at))"),"October")
        ->where('category_id','!=',null)->get()->count();
        }else{
        $count = SendersNumber::whereYear('created_at', date('Y'))->where(DB::raw("(MONTHNAME(created_at))"),"October")
        ->where('category_id','!=',null)->where('church_id',Auth::user()->church_id)
        ->get()->count();
        }
        return $count;
    }
    public function getSubscribersInNovember(){
        if(Auth::user()->church_id == 1){
        $count = SendersNumber::whereYear('created_at', date('Y'))->where(DB::raw("(MONTHNAME(created_at))"),"November")
        ->where('category_id','!=',null)
        ->get()->count();
        }else{
        $count = SendersNumber::whereYear('created_at', date('Y'))->where(DB::raw("(MONTHNAME(created_at))"),"November")
        ->where('category_id','!=',null)->where('church_id',Auth::user()->church_id)
        ->get()->count();
        }
        return $count;
    }
    public function getSubscribersInDecember(){
        if(Auth::user()->church_id == 1){
            $count = SendersNumber::whereYear('created_at', date('Y'))->where(DB::raw("(MONTHNAME(created_at))"),"December")
            ->where('category_id','!=',null)->get()->count();
        }else{
            $count = SendersNumber::whereYear('created_at', date('Y'))->where(DB::raw("(MONTHNAME(created_at))"),"December")
            ->where('category_id','!=',null)->where('church_id',Auth::user()->church_id)
            ->get()->count();
        }

        return $count;
    }

    public function getMaximumsubscribersOfACategory(){
        if(Auth::user()->church_id == 1){
            $max_category_id = SendersNumber::where('category_id','!=',null)->max('category_id');
            $count = SendersNumber::where('category_id',$max_category_id)->get();
        }else{
            $max_category_id = SendersNumber::where('category_id','!=',null)->where('church_id',Auth::user()->church_id)->max('category_id');
            $count = SendersNumber::where('category_id',$max_category_id)->get()->count();
        }
        return $count;
    }
    public function getMinimumsubscribersOfACategory(){
        if(Auth::user()->church_id == 1){
            $max_category_id = SendersNumber::where('category_id','!=',null)->min('category_id');
            $count = SendersNumber::where('category_id',$max_category_id)->get();
        }else{
            $max_category_id = SendersNumber::where('category_id','!=',null)->where('church_id',Auth::user()->church_id)->min('category_id');
            $count = SendersNumber::where('category_id',$max_category_id)->get()->count();
        }
        return $count;
    }


    public function getMaximumCategoryOfAChurch(){
        if(Auth::user()->church_id == 1){
            $max_category_id = SendersNumber::where('category_id','!=',null)->get()->max('category_id');
            $category = category::where('id',$max_category_id)->value('title');
        }else{
            $max_category_id = SendersNumber::where('category_id','!=',null)->where('church_id',Auth::user()->church_id)->get()->max('category_id');
            $category = category::where('id',$max_category_id)->value('title');
        }
        return $category;
    }


    public function getMinimumCategoryOfAChurch(){
        if(Auth::user()->church_id == 1){
            $min_category_id = SendersNumber::where('category_id','!=',null)->min('category_id');
            $category = category::where('id',$min_category_id)->value('title');
        }else{
            $min_category_id = SendersNumber::where('category_id','!=',null)->where('church_id',Auth::user()->church_id)->min('category_id');
            $category = category::where('id',$min_category_id)->value('title');
        }
        return $category;
    }
    public function countGroupsTotalContactsOfAChurch(){
        if(Auth::user()->church_id == 1){
            $contacts = Contacts::count();
            return $contacts;
        }else{
            $contacts = Contacts::where('church_id',Auth::user()->church_id)->count();
            return $contacts;
        }
    }
    public function countCategoriesTotalContactsOfAChurch(){
        if(Auth::user()->church_id == 1){
            $contacts = SendersNumber::where('contact','!=',null)->groupBy('category_id')->count();
            return $contacts;
        }else{
            $contacts = SendersNumber::where('church_id',Auth::user()->church_id)->where('contact_id','!=',null)->groupBy('category_id')->count();
            return $contacts;
        }
    }
    public function getTotalAmountLeft(){
        
        
        if(!$sock = @fsockopen('www.google.com', 80))
        {
            return null;
        }
        else
        {
            $url = "http://www.egosms.co/api/v1/plain/?method=Balance&username=microsoft&password=123456";
            return file_get_contents($url);
        }
        
    }
    public function getTotalSmsLeft(){
        $number_of_sms = $this->getTotalAmountLeft()/33.3;
        if(!$sock = @fsockopen('www.google.com', 80))
        {
            return null;
        }
        else
        {
            return floor($number_of_sms);
        }
    }

    public function getCountOfUncategorized(){
        if(Auth::user()->church_id == 1){
            $no_category = messages::where('messages.category_id',null)
            ->join('senders_numbers','senders_numbers.id','messages.message_from')->where('message_from','!=', null)
            ->count();
        }else{
            $no_category = messages::where('messages.church_id',Auth::user()->church_id)->where('messages.category_id',null)
            ->join('senders_numbers','senders_numbers.id','messages.message_from')->where('message_from','!=', null)
            ->count();
        }
        return $no_category;
    }

    public function getUserPermisions(){
        $empty_permisions_array = [];
        $permisions_array = DB::table('permisions_roles')
        ->join('permisions','permisions.id','permisions_roles.permision_id')
        ->where('role_id',Auth::user()->role_id)
        ->select('permisions.permision')->get();
        foreach(json_decode($permisions_array,true) as $permisions){
                array_push($empty_permisions_array,$permisions["permission_description"]);
        }
        return $empty_permisions_array;
    }

}
