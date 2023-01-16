<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\registerRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class registerController extends Controller
{
    public function register (registerRequest $users){
        $con = New User();

        $con->name = $users->ad;
        $con->email = $users->email;
        $con->block='0';
        $con->password = Hash::make($users->password); 

        $con->save();
        return view('register')->with('regist','Successfully registered!');
    }
}
