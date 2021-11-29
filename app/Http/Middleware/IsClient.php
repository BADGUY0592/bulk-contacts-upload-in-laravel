<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsClient
{
     public function handle(Request $request, Closure $next)
    {
        if(Auth::User()->isUser ==1){
            return $next($request);
        } 
        else{
            return abort(404);
        }

    }
}
