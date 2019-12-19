<?php
namespace App\Http\Controllers;
use App\Contacts;
use App\Exports\ContactsExport;
use App\Groups;
use App\Imports\ContactsImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;
class ContactsController extends Controller {
    //It redirects to a page showing all contacts
    public function index() {
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Contacts  $contacts
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contacts $contacts) {
        //

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Contacts  $contacts
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contacts $contacts) {
        //

    }
    public function view_for_group($id, Request $request) {
        $group = Contacts::join('Groups', 'contacts.group_id', 'Groups.id')
        ->join('church_databases', 'church_databases.id', 'contacts.church_id')
        ->join('users', 'users.id', 'contacts.created_by')->where('group_id', $id)
        ->where('contacts.church_id', Auth::user()->church_id)->first();

        $contacts = json_decode($group->contact_number);
        $contacts = array_slice($contacts, 1);

        $count = count($contacts);
        $offset = ($request->page - 1) * 10;
        $contacts = new LengthAwarePaginator(array_slice($contacts, $offset, 10), $count, 10, $request->page);
        $contacts->withPath("/view-contacts/$id");

        return view('after_login.contacts', compact('group', 'contacts'));
    }
    //save contact to group
    public function save_contact_to_group($id, Request $request) {
        if (empty($request->contact)) {
            return Redirect()->back();
        }
        if (ctype_alpha($request->contact)) {
            return Redirect()->back()->withInput()->withErrors("Please put a correct phone number with no plus, syntax used is: 256*********");
        }
        if  (preg_match('/[a-zA-Z]+$/', $request->contact)) {
            return Redirect()->back()->withInput()->withErrors("Please input a correct number, it should not be alpha numeric");
        }
        if (strpos($request->contact, '.') == true) {
            return Redirect()->back()->withInput()->withErrors("Please put a correct phone number with no plus, syntax used is: 256*********");
        } elseif (strpos($request->contact, '!') == true) {
            return Redirect()->back()->withInput()->withErrors("Please put a correct phone number with no plus, syntax used is: 256*********");
        } elseif (strpos($request->contact, '@') == true) {
            return Redirect()->back()->withInput()->withErrors("Please put a correct phone number with no plus, syntax used is: 256*********");
        } elseif (strpos($request->contact, '#') == true) {
            return Redirect()->back()->withInput()->withErrors("Please put a correct phone number with no plus, syntax used is: 256*********");
        } elseif (strpos($request->contact, '$') == true) {
            return Redirect()->back()->withInput()->withErrors("Please put a correct phone number with no plus, syntax used is: 256*********");
        } elseif (strpos($request->contact, '%') == true) {
            return Redirect()->back()->withInput()->withErrors("Please put a correct phone number with no plus, syntax used is: 256*********");
        } elseif (strpos($request->contact, '^') == true) {
            return Redirect()->back()->withInput()->withErrors("Please put a correct phone number with no plus, syntax used is: 256*********");
        } elseif (strpos($request->contact, '&') == true) {
            return Redirect()->back()->withInput()->withErrors("Please put a correct phone number with no plus, syntax used is: 256*********");
        } elseif (strpos($request->contact, '*') == true) {
            return Redirect()->back()->withInput()->withErrors("Please put a correct phone number with no plus, syntax used is: 256*********");
        } elseif (strpos($request->contact, '"') == true) {
            return Redirect()->back()->withInput()->withErrors("Please put a correct phone number with no plus, syntax used is: 256*********");
        } elseif (strpos($request->contact, ',') == true) {
            return Redirect()->back()->withInput()->withErrors("Please put a correct phone number with no plus, syntax used is: 256*********");
        } elseif (strpos($request->contact, ':') == true) {
            return Redirect()->back()->withInput()->withErrors("Please put a correct phone number with no plus, syntax used is: 256*********");
        } elseif (strpos($request->contact, '\'') == true) {
            return Redirect()->back()->withInput()->withErrors("Please put a correct phone number with no plus, syntax used is: 256*********");
        } elseif (strpos($request->contact, '?') == true) {
            return Redirect()->back()->withInput()->withErrors("Please put a correct phone number with no plus, syntax used is: 256*********");
        } elseif (strpos($request->contact, ';') == true) {
            return Redirect()->back()->withInput()->withErrors("Please put a correct phone number with no plus, syntax used is: 256*********");
        } elseif (strpos($request->contact, '/') == true) {
            return Redirect()->back()->withInput()->withErrors("Please put a correct phone number with no plus, syntax used is: 256*********");
        } elseif (strpos($request->contact, '}') == true) {
            return Redirect()->back()->withInput()->withErrors("Please put a correct phone number with no plus, syntax used is: 256*********");
        } elseif (strpos($request->contact, '{') == true) {
            return Redirect()->back()->withInput()->withErrors("Please put a correct phone number with no plus, syntax used is: 256*********");
        } elseif (strpos($request->contact, '[') == true) {
            return Redirect()->back()->withInput()->withErrors("Please put a correct phone number with no plus, syntax used is: 256*********");
        } elseif (strpos($request->contact, ']') == true) {
            return Redirect()->back()->withInput()->withErrors("Please put a correct phone number with no plus, syntax used is: 256*********");
        } elseif (strpos($request->contact, '-') == true) {
            return Redirect()->back()->withInput()->withErrors("Please put a correct phone number with no plus, syntax used is: 256*********");
        } elseif (strpos($request->contact, '_') == true) {
            return Redirect()->back()->withInput()->withErrors("Please put a correct phone number with no plus, syntax used is: 256*********");
        } elseif (strpos($request->contact, '=') == true) {
            return Redirect()->back()->withInput()->withErrors("Please put a correct phone number with no plus, syntax used is: 256*********");
        } elseif (strpos($request->contact, '+') == true) {
            return Redirect()->back()->withInput()->withErrors("Please put a correct phone number with no plus, syntax used is: 256*********");
        } elseif (strpos($request->contact, '(') == true) {
            return Redirect()->back()->withInput()->withErrors("Please put a correct phone number with no plus, syntax used is: 256*********");
        } elseif (strpos($request->contact, ')') == true) {
            return Redirect()->back()->withInput()->withErrors("Please put a correct phone number with no plus, syntax used is: 256*********");
        } elseif (strlen($request->contact) > 12) {
            return Redirect()->back()->withInput()->withErrors("The Number count is supposed to be exactly 12");
        } elseif (strlen($request->contact) < 12) {
            return Redirect()->back()->withInput()->withErrors("The Number count is supposed to be exactly 12");
        } elseif ($request->contact[0] != 2) {
            return Redirect()->back()->withInput()->withErrors("Required numbers only start with 256");
        } elseif ($request->contact[1] != 5) {
            return Redirect()->back()->withInput()->withErrors("Required numbers only have 5 as their second digit");
        } elseif ($request->contact[2] != 6) {
            return Redirect()->back()->withInput()->withErrors("Required numbers only have 6 as their third number");
        }
        elseif ($request->contact[2] != 6) {
            return Redirect()->back()->withInput()->withErrors("Input a correct phone number");
        }
        $check_if_element_exists_array = [];
        $contact_array = json_decode(Contacts::where('contacts.group_id', $id)->value('contact_number'));
        foreach ($contact_array as $item) {
            array_push($check_if_element_exists_array, $item->Contact);
            if (in_array($request->contact, $check_if_element_exists_array)) {
                return Redirect()->back()->withInput()->withErrors("Contact is already registered under this group");
            }
        }
        $nospace_request = str_replace(" ", "", $request->contact);
        $empty_array = array('Contact' => $nospace_request, 'name' => $request->name);
        array_push($contact_array, $empty_array);
        //saving new array to the database
        Contacts::where('contacts.group_id', $id)->update(array('contact_number' => json_encode($contact_array)));
        Groups::where('id', $id)->update(array('number_of_contacts' => count($contact_array) -1));
        return Redirect()->back();
    }
    public function remove_element_from_an_array($group_id, Request $request) {
        $empty_array = array();
        $contact_array = json_decode(Contacts::where('contacts.group_id', $group_id)->value('contact_number'), true);
        unset($contact_array[$request->index_to_delete + 1]);
        foreach($contact_array as $array){
            array_push($empty_array, $array);
        }
        //return (json_encode($contact_array));
        Contacts::where('contacts.group_id', $group_id)->update(array('contact_number' => json_encode($empty_array)));
        //$counted = json_decode($contact_array);
        Groups::where('id', $group_id)->update(array('number_of_contacts' => count($empty_array) -1));
        return Redirect()->back()->withInput()->withErrors("Contact was deleted Successfully");
    }
    public function import() {
        Excel::import(new ContactsImport, request()->file('file'));
        return back();
    }
    public function export() {
        return Excel::download(new ContactsExport, 'contacts.xlsx');
    }
}
