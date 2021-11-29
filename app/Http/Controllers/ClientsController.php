<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ClientsController extends Controller
{
    public function show($uid){
        $user=User::where('isAdmin',0)
            ->where('id',$uid)
            ->first();
        return view('Client.show')
            ->with('client',$user);
    }

    public function update(Request $request){
        //dd($request->all());
        $this->validate($request,[
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'user' => 'required|string',
        ]);

        User::where('id',$request->user)
        ->update([
           'name' => ucwords(strtolower($request->name)),
           'email' => $request->email
        ]);

        Session::flash('flash_type','success');
        Session::flash('flash_message', 'User Updated Successfully.'); 

        return redirect()->back();
    }

    public function delete($uid){
        User::where('isAdmin',0)
            ->where('id',$uid)
            ->delete();

        Session::flash('flash_type','danger');
        Session::flash('flash_message', 'User Deleted Successfully.'); 

        return redirect('/home');
    }
}
