<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class profileController extends Controller
{

    public function profile(){
        $sec = User::find(Auth::id());
        return view('profile',[
            'data'=>$sec
        ]);
    }

    public function submit(Request $users){
        
        $con = User::find(Auth::id());

        if(empty($users->npassword)){ 
    
            if(Hash::check($users->cpassword,$con->password)){

               

                if($users->file('image')){
                    $file = time().'.'.$users->image->extension();
                    $users->image->storeAs('public/uploads/users/',$file);
                    $con->foto = 'storage/uploads/users/'.$file;  
                }

                $con->name = $users->name;
                $con->email = $users->email;
                $con->password = Hash::make($users->password);
                $con->save();

                return redirect()->route('profil')->with('success','Profil successfully updated');
            }

           return redirect()->route('profil')->with('wrong','wrong password or passwords do not match');
            
        }

        if($users->npassword){

            if(Hash::check($users->cpassword,$con->password)){
                if($users->file('image')){
                    $file = time().'.'.$users->image->extension();
                    $users->image->storeAs('public/uploads/users/',$file);
                    $con->foto = 'storage/uploads/users/'.$file;
                }

                $con->name = $users->name;
                $con->email = $users->email;
                $con->password = Hash::make($users->npassword);
                $con->save();

                return redirect()->route('profil')->with('success','Profil successfully updated!');
            }

            
            return redirect()->route('profil')->with('wrong','Wrong password or passwords do not match');

        }

    }
}
