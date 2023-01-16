<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class loginController extends Controller
{
    public function login (Request $giris){
        if(!Auth::attempt(['email'=>$giris->email,'password'=>$giris->password])){
            return redirect()->back()->with('danger','Not a valid email or password!');
        }

        return redirect()->route('blist');


    }

    public function logout(){
        auth()->logout();
        return redirect()->route('login');
    }
}
