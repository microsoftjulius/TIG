<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PackagesModel;
use App\category;
use App\SubscribedForMessages;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\messages;

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
    public function getChurchPackages(){
        if(Auth::user()->church_id == 1){
            $all_packages = PackagesModel::join('category','category.id','packages.category_id')->paginate('10');
        }else{
            $all_packages = PackagesModel::join('category','category.id','packages.category_id')
            ->where('packages.church_id',Auth::user()->church_id)->paginate('10');
        }
        return view('after_login.packages',compact('all_packages'));
    }

    public function createAutomaticPackage(Request $request){
        $church_id = 1;
        $category_id = 2;
        PackagesModel::create(array(
            'church_id'      => $church_id,
            'category_id'    => $category_id,
            'contact_number' => $this->contact_number,
            'time_frame'     => $this->time_frame,
            'Amount'         => $this->amount,
            'type'           => 'Automatic'
        ));
        return redirect('/packages')->with('message', 'New Package Subscription has been created  Successfully');
    }

    public function selectSubscribedForMessagesTitle(){
        $subscribes_for_messages = category::where('church_id',Auth::user()->church_id)->get();
        return view('after_login.new-subscription-form',compact('subscribes_for_messages'));
    }

    public function createASubscriptionTimeFrame(Request $request){

        if(category::where('title',$request->category_id)->doesntExist()){
            return redirect()->back()->withInput()->withErrors("Kindly just choose the categories listed, or create a new category");
        }
        $category_id = category::where('title',$request->category_id)->value('id');
        PackagesModel::create(array(
            'church_id'      => Auth::user()->church_id,
            'category_id'    => $category_id,
            'time_frame'     => $this->time_frame,
            'Amount'         => $this->Amount,
        ));
        return redirect('/packages')->with('message', 'New Subscription Type has been created Successfully');
    }

    public function getPaymentLogs(){
        $all_packages = messages::join('category','category.id','messages.category_id')
        ->join('packages','packages.category_id','category.id')
        ->where('packages.church_id',Auth::user()->church_id)
        ->paginate('10');
        return view('after_login.log',compact('all_packages'));
    }
}
