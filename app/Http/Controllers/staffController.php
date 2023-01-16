<?php

namespace App\Http\Controllers;
use App\Models\Staff;
use App\Models\Document;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class staffController extends Controller
{
    
    public function staff(){
        $say = Staff::where('user_id',Auth::id())->count();
        $sec = Staff::where('user_id','=',Auth::id())->get(); 
        return view('staff',[
            'data'=>$sec,
            'say'=>$say
        ]);
    }

    public function add(Request $staff){
        $con = New Staff();

        if($staff->file('image')){
            $file = time().'.'.$staff->image->extension();
            $staff->image->storeAs('public/uploads/staff/',$file);
            $con->foto = 'storage/uploads/staff/'.$file;
        }

        $con->user_id = Auth::id();
        $con->name = $staff->name;
        $con->position = $staff->position;
        $con->wage = $staff->wage;
        $con->hired_at = $staff->hire;
        $con->phone = $staff->phone;
        $con->birthdate = $staff->bdate;
        $con->save();

        return redirect()->route('staff')->with('success','Staff member is added');
    }

    public function edit($id){
       
        $sec = Staff::find($id);
        $sec2 = Staff::orderBy('id','desc')->where('user_id','=',Auth::id())->get();

        return view('staff',[
            'editdata'=>$sec,
            'data'=>$sec2
        ]);
    }

    public function update(Request $staff){
        $con = Staff::find($staff->id);

        if($staff->file('image')){
            $file = time().'.'.$staff->image->extension();
            $staff->image->storeAs('public/uploads/staff/',$file);
            $con->foto = 'storage/uploads/staff/'.$file;
        }

        $con->name = $staff->name;
        $con->position = $staff->position;
        $con->wage = $staff->wage;
        $con->hired_at = $staff->hire;
        $con->phone = $staff->phone;
        $con->birthdate = $staff->bdate;
        $con->save();

        return redirect()-> route('staff')->with('update','Staff member successfully updated!');
    }

    public function delete($id){
        $say = Staff::where('user_id',Auth::id())->count();
        $sec = Staff::orderBy('id','desc')->where('user_id','=',Auth::id())->get();

        return view('staff',[
            'data'=>$sec,
            'sil_id'=>$id,
            'say'=>$say
        ]);
    }

    public function sil($id){
        $con = Staff::find($id)->delete();
        return redirect() -> route('staff')->with('delete','Staff member deleted!');
    }

    public function document($id){
         $sec = Document::find($id);
         $sec2 = Document::join('staff','staff.id','=','documents.staff_id')
        ->select('documents.staff_id','documents.id','documents.title','documents.document','documents.note','documents.created_at','documents.updated_at','staff.id')
        ->where('staff.id','=',$id)
        ->get();

        $sec3 = Staff::find($id);

        return view('document',[
            'document'=>$sec,
            'data'=>$sec2,
            'staff'=>$sec3
        ]);

    }
 
    public function docadd(Request $document){
        $con = New Document();
        $con->staff_id = $document->id; 

        $con->title = $document->title;

        if($document->file('document')){ 
            $file = time().'.'.$document->document->extension();
            $document->document->storeAs('public/uploads/documents/',$file);
            $con->document = 'storage/uploads/documents/'.$file;
        }

        $con -> note = $document->note;
        $con->save();

        return redirect()->route('document')->with('success','Documents successfully added');

        

    }


}
