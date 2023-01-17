<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class CustomAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

$path = $request->path();





if(($path == "login") && (Session::get('user'))){
    if(Session::get('position')=="Driver"){
        return redirect('/homeDriver');
    }
    return redirect('/');
} elseif($path != "login" && !((Session::get('user')))){
    return redirect('/login');
}


        return $next($request);


    }
}
