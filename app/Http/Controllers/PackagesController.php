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
        return redirect('/packages')->with('message', 'New Package Subscription has been created  Successfully');
    }

    public function selectSubscribedForMessagesTitle(){
        $subscribes_for_messages = category::where('church_id',Auth::user()->church_id)->get();
        return view('after_login.new-subscription-form',compact('subscribes_for_messages'));
    }

    public function createManualSubscription(Request $request){
        if (empty($request->contact_number)) {
            return Redirect()->back()->withInput()->withErrors("Contact information cannot be null");
        }
        if (ctype_alpha($request->contact_number)) {
            return Redirect()->back()->withInput()->withErrors("Please put a correct phone number with no plus, syntax used is: 256*********");
        }
        if  (preg_match('/[a-zA-Z]+$/', $request->contact_number)) {
            return Redirect()->back()->withInput()->withErrors("Please input a correct number, it should not be alpha numeric");
        }
        if (strpos($request->contact_number, '.') == true) {
            return Redirect()->back()->withInput()->withErrors("Please put a correct phone number with no plus, syntax used is: 256*********");
        } elseif (strpos($request->contact_number, '!') == true) {
            return Redirect()->back()->withInput()->withErrors("Please put a correct phone number with no plus, syntax used is: 256*********");
        } elseif (strpos($request->contact_number, '@') == true) {
            return Redirect()->back()->withInput()->withErrors("Please put a correct phone number with no plus, syntax used is: 256*********");
        } elseif (strpos($request->contact_number, '#') == true) {
            return Redirect()->back()->withInput()->withErrors("Please put a correct phone number with no plus, syntax used is: 256*********");
        } elseif (strpos($request->contact_number, '$') == true) {
            return Redirect()->back()->withInput()->withErrors("Please put a correct phone number with no plus, syntax used is: 256*********");
        } elseif (strpos($request->contact_number, '%') == true) {
            return Redirect()->back()->withInput()->withErrors("Please put a correct phone number with no plus, syntax used is: 256*********");
        } elseif (strpos($request->contact_number, '^') == true) {
            return Redirect()->back()->withInput()->withErrors("Please put a correct phone number with no plus, syntax used is: 256*********");
        } elseif (strpos($request->contact_number, '&') == true) {
            return Redirect()->back()->withInput()->withErrors("Please put a correct phone number with no plus, syntax used is: 256*********");
        } elseif (strpos($request->contact_number, '*') == true) {
            return Redirect()->back()->withInput()->withErrors("Please put a correct phone number with no plus, syntax used is: 256*********");
        } elseif (strpos($request->contact_number, '"') == true) {
            return Redirect()->back()->withInput()->withErrors("Please put a correct phone number with no plus, syntax used is: 256*********");
        } elseif (strpos($request->contact_number, ',') == true) {
            return Redirect()->back()->withInput()->withErrors("Please put a correct phone number with no plus, syntax used is: 256*********");
        } elseif (strpos($request->contact_number, ':') == true) {
            return Redirect()->back()->withInput()->withErrors("Please put a correct phone number with no plus, syntax used is: 256*********");
        } elseif (strpos($request->contact_number, '\'') == true) {
            return Redirect()->back()->withInput()->withErrors("Please put a correct phone number with no plus, syntax used is: 256*********");
        } elseif (strpos($request->contact_number, '?') == true) {
            return Redirect()->back()->withInput()->withErrors("Please put a correct phone number with no plus, syntax used is: 256*********");
        } elseif (strpos($request->contact_number, ';') == true) {
            return Redirect()->back()->withInput()->withErrors("Please put a correct phone number with no plus, syntax used is: 256*********");
        } elseif (strpos($request->contact_number, '/') == true) {
            return Redirect()->back()->withInput()->withErrors("Please put a correct phone number with no plus, syntax used is: 256*********");
        } elseif (strpos($request->contact_number, '}') == true) {
            return Redirect()->back()->withInput()->withErrors("Please put a correct phone number with no plus, syntax used is: 256*********");
        } elseif (strpos($request->contact_number, '{') == true) {
            return Redirect()->back()->withInput()->withErrors("Please put a correct phone number with no plus, syntax used is: 256*********");
        } elseif (strpos($request->contact_number, '[') == true) {
            return Redirect()->back()->withInput()->withErrors("Please put a correct phone number with no plus, syntax used is: 256*********");
        } elseif (strpos($request->contact_number, ']') == true) {
            return Redirect()->back()->withInput()->withErrors("Please put a correct phone number with no plus, syntax used is: 256*********");
        } elseif (strpos($request->contact_number, '-') == true) {
            return Redirect()->back()->withInput()->withErrors("Please put a correct phone number with no plus, syntax used is: 256*********");
        } elseif (strpos($request->contact_number, '_') == true) {
            return Redirect()->back()->withInput()->withErrors("Please put a correct phone number with no plus, syntax used is: 256*********");
        } elseif (strpos($request->contact_number, '=') == true) {
            return Redirect()->back()->withInput()->withErrors("Please put a correct phone number with no plus, syntax used is: 256*********");
        } elseif (strpos($request->contact_number, '+') == true) {
            return Redirect()->back()->withInput()->withErrors("Please put a correct phone number with no plus, syntax used is: 256*********");
        } elseif (strpos($request->contact_number, '(') == true) {
            return Redirect()->back()->withInput()->withErrors("Please put a correct phone number with no plus, syntax used is: 256*********");
        } elseif (strpos($request->contact_number, ')') == true) {
            return Redirect()->back()->withInput()->withErrors("Please put a correct phone number with no plus, syntax used is: 256*********");
        } elseif (strlen($request->contact_number) > 12) {
            return Redirect()->back()->withInput()->withErrors("The Number count is supposed to be exactly 12");
        } elseif (strlen($request->contact_number) < 12) {
            return Redirect()->back()->withInput()->withErrors("The Number count is supposed to be exactly 12");
        } elseif ($request->contact_number[0] != 2) {
            return Redirect()->back()->withInput()->withErrors("Required numbers only start with 256");
        } elseif ($request->contact_number[1] != 5) {
            return Redirect()->back()->withInput()->withErrors("Required numbers only have 5 as their second digit");
        } elseif ($request->contact_number[2] != 6) {
            return Redirect()->back()->withInput()->withErrors("Required numbers only have 6 as their third number");
        }
        elseif ($request->contact_number[2] != 6) {
            return Redirect()->back()->withInput()->withErrors("Input a correct phone number");
        }elseif ($request->contact_number[3] != 7) {
            return Redirect()->back()->withInput()->withErrors("Input a correct phone number");
        }
        if(category::where('title',$request->category_id)->doesntExist()){
            return redirect()->back()->withInput()->withErrors("Kindly just choose the categories listed, or create a new category");
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
        return redirect('/packages')->with('message', 'New Package subscription has been created Successfully');;
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
