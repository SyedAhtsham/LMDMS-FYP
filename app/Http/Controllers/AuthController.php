<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Support\Facades;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;


class AuthController extends Controller
{
    //

    public function index(){
        return view('auth.login');
    }

    public function login(Request $request){




        $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required',
        ]);




$email = $request['email'];
$password = $request['password'];




        $user = User::where('email', $email)->get();

        if(isset($user[0])) {

            if ($user[0]->password == $password) {
                $staff = Staff::find($user[0]->staff_id);



                $request->session()->put('user', $staff->name);
                $request->session()->put('staff_id', $staff->staff_id);
                $request->session()->put('position', $staff->position);


                if($staff->position == "Driver"){
                    return redirect('homeDriver')->withSuccessMessage("You're Logged in Successfully!");
                }else {
                    return redirect('home')->withSuccessMessage("You're Logged in Successfully!");
                }
            }else{
                return redirect('login')->withError('This password is incorrect!');
            }

        }else{
            return redirect('login')->withError('This email is not registered!');
        }


        return redirect('login')->withError('Log in details are not valid');
    }

    public function home(){

        return view('frontend.index');
    }

    public function homeDriver(){

        return view('frontend.indexDriver');
    }


    public function logout(Request $request){
        $request->session()->forget('user');
        $request->session()->forget('staff_id');
        $request->session()->forget('position');
$flag = true;
$data = compact('flag');
        return view('auth.login')->with($data);
    }


}
