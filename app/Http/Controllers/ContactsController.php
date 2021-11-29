<?php

namespace App\Http\Controllers;

use App\Contact;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ContactsController extends Controller
{
    public function store(Request $request){
        // dd($request->all());
        if($request->hasFile('bulkupload')){
            $this->validate($request,[
                'bulkupload' => 'mimes:xlsx'
            ]);
        }else{
            $this->validate($request,[
                'name' => 'required|string|max:255',
                'mobile' => 'required|string|max:12',
            ]); 
            if(Auth::User()->isAdmin == 1){
                $this->validate($request,[
                    'user' => 'required'
                ]);
                Contact::create([
                    'user_id' => $request->user,
                    'name' => $request->name,
                    'mobile' => $request->mobile
                ]);
            }else{
                Contact::create([
                    'user_id' => Auth::User()->id,
                    'name' => $request->name,
                    'mobile' => $request->mobile
                ]);
            }
        }
        Session::flash('flash_type','success');
        Session::flash('flash_message', 'Contact Added Successfully.'); 

        return redirect()->back();
    }

    public function update(Request $request){
        // dd($request->all());
        $this->validate($request,[
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|max:12',
            'contact' => 'required'
        ]); 

        $contact=Contact::where('id',$request->contact)
            ->where(function($q){
                if(Auth::User()->isAdmin == 0){
                    $q->where('user_id',Auth::User()->id);
                }
            })
        ->first();
        if($contact != NULL){
            $contact->update([
                'name' => $request->name,
                'mobile' => $request->mobile
            ]);
        }else{
            return abort(404);
        }

        Session::flash('flash_type','success');
        Session::flash('flash_message', 'Contact Updated Successfully.'); 

        return redirect()->back();
    }

    public function delete($cid){
        $contact=Contact::where('id',$cid)
            ->where(function($q){
                if(Auth::User()->isAdmin == 0){
                    $q->where('user_id',Auth::User()->id);
                }
            })
        ->first();
        if($contact != NULL){
            $contact->delete();
        }else{
            return abort(404);
        }
        Session::flash('flash_type','danger');
        Session::flash('flash_message', 'Contact Deleted Successfully.'); 

        return redirect()->back();
    }

    public function getdetails($cid){
        $contact=Contact::where('id',$cid)
            ->where(function($q){
                if(Auth::User()->isAdmin == 0){
                    $q->where('user_id',Auth::User()->id);
                }
            })
        ->first();
        return $contact;
    }
}
