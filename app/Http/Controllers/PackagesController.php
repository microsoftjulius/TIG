<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PackagesModel;
use App\category;
use App\SubscribedForMessages;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PackagesController extends Controller
{
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
            'contact_number' => $request->contact_number,
            'time_frame'     => $request->time_frame,
            'Amount'         => $request->amount,
            'type'           => 'Automatic'
        ));
        return redirect('/packages')->withErrors("New Package Subscription has been created");
    }

    public function selectSubscribedForMessagesTitle(){
        $subscribes_for_messages = category::where('church_id',Auth::user()->church_id)->get();
        return view('after_login.new-subscription-form',compact('subscribes_for_messages'));
    }

    public function createManualSubscription(Request $request){
        if(category::where('title',$request->category_id)->doesntExist()){
            return redirect()->back()->withErrors("Kindly just choose the categories listed, or create a new category");
        }
        $category_id = category::where('title',$request->category_id)->value('id');
        PackagesModel::create(array(
            'church_id'      => Auth::user()->church_id,
            'category_id'    => $category_id,
            'contact_number' => $request->contact_number,
            'time_frame'     => $request->time_frame,
            'Amount'         => $request->Amount,
            'type'           => 'Manual'
        ));
        return redirect('/packages')->withErrors("New Package Subscription has been created");
    }

    public function getPaymentLogs(){
            $all_packages = PackagesModel::join('category','category.id','packages.category_id')
            ->join('church_databases','church_databases.id','category.church_id')
            ->where('church_databases.id',Auth::user()->church_id)
            ->select('church_databases.church_name','packages.amount','category.created_at')
            ->paginate('10');
            return view('after_login.log',compact('all_packages'));
    }
}
