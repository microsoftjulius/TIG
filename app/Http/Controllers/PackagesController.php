<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PackagesModel;
use App\category;
use App\SubscribedForMessages;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\messages;
use App\package_category;

class PackagesController extends Controller
{
    public function __construct(Request $request){
        $this->error_message = new ErrorMessagesController();
        $this->contacts_format = ['25677','25678','25670','25679','25671','25675','25675',
        '25620','25639','25641'];
        $this->contact_length = 12;
        $this->contact_number = $request->contact_number;
        $this->user_name = $request->name;
        $this->time_frame = $request->time_frame;
        $this->amount = $request->amount;
        $this->Amount = $request->Amount;
    }

    public function createPackage(){
        PackagesModel::create(array(
            'package_name' => request()->package,
            'church_id'    => Auth::user()->church_id,
            'time_frame'   => request()->time_frame,
            'Amount'       => request()->Amount
        ));
        return redirect('/packages')->with('message','New Package Subscription has been created');
    }

    public function getChurchPackages(){
        if(Auth::user()->church_id == 1){
            $all_packages = PackagesModel::join('church_databases','church_databases.id','packages.church_id')
            ->select('packages.*')
            ->paginate('10');
            $message_categories = category::paginate('10');
        }else{
            $all_packages = PackagesModel::where('church_id',Auth::user()->church_id)
            ->select('packages.*')
            ->paginate('10');

            $message_categories = category::where('church_id',Auth::user()->church_id)->paginate('10');
        }
        return view('after_login.packages',compact('all_packages','message_categories'));
    }

    public function selectSubscribedForMessagesTitle(){
        $subscribes_for_messages = category::where('church_id',Auth::user()->church_id)->get();
        return view('after_login.new-subscription-form',compact('subscribes_for_messages'));
    }

    public function createASubscriptionTimeFrame(Request $request){
        if(category::where('title',$request->category_id)->doesntExist()){
            return redirect()->back()->withInput()->withErrors("Kindly just choose the categories listed, or create a new category");
        }
        $category_id = category::where('title',$request->category_id)->where('church_id',Auth::user()->church_id)->value('id');
        PackagesModel::create(array(
            'church_id'      => Auth::user()->church_id,
            'category_id'    => $category_id,
            'time_frame'     => $this->time_frame,
            'Amount'         => $this->Amount,
        ));
        return redirect('/packages')->with('message', 'New Subscription Type has been created Successfully');
    }

    public function getPaymentLogs(){
        if(Auth::user()->church_id == 1){
            return $this->getPaymentLogsForAdmin();
        }
        else{
            return $this->getPaymentLogsForChurch();
        }
    }

    protected function getPaymentLogsForChurch(){
        $all_packages = messages::join('category','category.id','messages.category_id')
        ->join('package_category','package_category.category_id','category.id')
        ->join('packages','packages.id','package_category.package_id')
        ->where('package_category.church_id',Auth::user()->church_id)
        ->orderBy('messages.id','Desc')
        ->paginate('10');
        return view('after_login.log',compact('all_packages'));
    }

    protected function getPaymentLogsForAdmin(){
        $all_packages = messages::join('category','category.id','messages.category_id')
        ->join('package_category','package_category.category_id','category.id')
        ->join('packages','packages.id','package_category.package_id')
        ->orderBy('messages.id','Desc')
        ->paginate('10');
        return view('after_login.log',compact('all_packages'));
    }

    public function mapCategoryToPackage(){
        
        if(empty(request()->category) && empty(request()->package)){
            return redirect()->back()->withErrors("please select atleast one category and one package");
        }
        if(empty(request()->category)){
            return redirect()->back()->withErrors("please select atleast one category");
        }
        if(empty(request()->package)){
            return redirect()->back()->withErrors("please select atleast one Package");
        }
        $catsArray = [];
        foreach(request()->category as $category){
            if(DB::table('package_category')->where('package_id',request()->package)
            ->where('category_id',request()->category)->where('church_id',Auth::user()->church_id)->exists()){
                continue;
            }else{
                array_push($catsArray, $category);
            }
        }
        foreach($catsArray as $cats){
            
            package_category::create(array(
                'package_id'    => request()->package,
                'category_id'   => $cats,
                'church_id'     => Auth::user()->church_id
            ));
        }
        return redirect()->back()->with('message','A package has been attached to a message category successfully');
    }
}
