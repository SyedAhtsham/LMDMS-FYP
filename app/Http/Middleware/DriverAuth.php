<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DriverAuth
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

        $pathDrv =  $request->route()->getName();

$path = $request->path();


if($pathDrv == null && Session::get('position') == "Driver"){
    return redirect()->route('homeDriver');

}
        if(!((Session::get('position') == "Driver") && ($pathDrv != "view.singlestaff" || $pathDrv != "view.singlevehicle" || $pathDrv != "view.deliverysheet" || $pathDrv != "home" || $pathDrv != "login" || $pathDrv != "homeDriver" || $pathDrv != "logout")
            ))
        {
            if(Session::get('position') == "Driver" ){
            return redirect()->route('homeDriver');
        }
        }



        return $next($request);
    }
}
