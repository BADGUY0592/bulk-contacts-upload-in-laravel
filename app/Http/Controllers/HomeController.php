<?php

namespace App\Http\Controllers;

use App\Contact;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        if(Auth::User()->isAdmin == 1){
            $users=User::where('isAdmin',0)
                ->orderBy('id','DESC')
                ->withCount('contacts as contactscount')
                ->paginate(15);
            return view('home')
                ->with('users',$users);
        }else{
            $contacts=Contact::where('user_id',Auth::User()->id)
                ->orderBy('id','DESC')
                ->paginate(15);
            return view('home')
                ->with('contacts',$contacts);
        }
    }

    public function createuser(Request $request){
        //dd($request->all());
        $this->validate($request,[
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user=User::create([
           'name' => ucwords(strtolower($request->name)),
           'email' => $request->email,
           'password' => Hash::make($request->password),
        ]);

        if($request->role != NULL){
            $user->update([
                'isAdmin' => 1
            ]);
        }

        Session::flash('flash_type','success');
        Session::flash('flash_message', 'User Added Successfully.'); 

        return redirect()->back();
            
    }
}
