<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class loginController extends Controller
{
        public function login (Request $giris){
            
                if(!Auth::attempt(['email'=>$giris->email,'password'=>$giris->password,'block'=>0])){
                    
                return redirect()->back()->with('danger','Not a valid email or password!');
                }

                return redirect()->route('brand-list'); 
            
            
            return redirect()->back()->with('danger','User is blocked!');

        }

    public function logout(){
        auth()->logout();
        return redirect()->route('login');
    }
}
