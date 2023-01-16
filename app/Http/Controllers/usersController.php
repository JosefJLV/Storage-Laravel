<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class usersController extends Controller
{
    public function list(){
        $say = User::where('id','!=',1)->count();
        $sec = User::where('id','!=',1)->orderBy('id','desc')->get();

        return view('users',[
            'data'=>$sec,
            'say'=>$say
        ]);

    }

    public function add(Request $users){
        $con = New User();

        if($users->file('image')){
            $file = time().'.'.$users->image->extension();
            $users->image->storeAs('public/uploads/users/',$file);
            $con->foto = 'storage/uploads/users/'.$file;
        }

            $con->name = $users->name;
            $con->email = $users->email;
            $con->block ='0';
            $con->password = Hash::make($users->pass);
            $con->save();

            return redirect()->route('users')->with('success','New user is added');
    }
    public function block($id){
        $con = User::find($id);

        $con->block = 1;

        $con->save();

        return redirect()->route('users')->with('success','User is blocked');

    }

    public function unblock($id){
        $con = User::find($id);

        $con->block = 0;

        $con->save();

        return redirect()->route('users')->with('success','User successfully unblocked');

    }

    public function delete($id){
        $sec = User::get();

        return view('users',[
            'data'=>$sec,
            'sil_id'=>$id
        ]);
    }

    public function sil($id){
        $con = User::find($id)->delete();

        return redirect()->route('users')->with('success','User successfully deleted');
    }

    public function edit($id){
        $sec = User::find($id);
        $sec2 = User::orderBy('id','desc')->get();

        return  view('users',[
            'data'=>$sec2,
            'editdata'=>$sec
        ]);
}
        public function update(Request $users){
            $con = User::find($users->id);
            
            if($users->file('image')){
                $file = time().'.'.$users->image->extension();
                $users->image->storeAs('public/uploads/users/',$file);
                $con->foto = 'storage/uploads/users/'.$file;
            }
    
            $con->name = $users->name;
            $con->email = $users->email;
            $con->block ='0';
            $con->password = Hash::make($users->pass);
            $con->save();

            return redirect()->route('users')->with('success','User successfully updated');
            
        }
    
}
