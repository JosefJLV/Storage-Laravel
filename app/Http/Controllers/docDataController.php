<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Document;
use App\Models\Staff;
use Storage;
use Datatables;

class docDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function document($id){
        $sec = Document::find($id);

        $docsay = Document::join('staff','staff.id','=','documents.staff_id')->where('staff.id','=',$id)->count();

        $sec2 = Document::join('staff','staff.id','=','documents.staff_id')
       ->select('documents.staff_id','documents.id','documents.title','documents.document','documents.note','documents.created_at','documents.updated_at','staff.id as sid')
       ->where('staff.id','=',$id)
       ->get();

       $sec3 = Staff::find($id);

       return view('document',[
           'document'=>$sec,
           'data'=>$sec2,
           'staff'=>$sec3,
           'docsay'=>$docsay
       ]);

   }
     
     
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $document){
        $con = New Document();


        $sid = $con->staff_id = $document->id; 

        $con->title = $document->title;

        if($document->file('document')){ 
            $file = time().'.'.$document->document->extension();
            $document->document->storeAs('public/uploads/documents/',$file);
            $con->document = 'storage/uploads/documents/'.$file;
        }

        $con -> note = $document->note;
        $con->save();

        return redirect()->route('doc-list',$sid)->with('success','Documents successfully added');

        

    }
     
     
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $sec = Document::find($id);

        return view('document',[
            'editdata'=>$sec
        ]);
    }
     
    public function update(Request $document){
        $con = Document::find($document->id);
        $sid = $con->staff_id;

        $con->title = $document->title;

        if($document->file('document')){ 
            $file = time().'.'.$document->document->extension();
            $document->document->storeAs('public/uploads/documents/',$file);
            $con->document = 'storage/uploads/documents/'.$file;
        }

        $con -> note = $document->note;
        $con->save();

        return redirect()->route('doc-list',$sid)->with('update','Successfully updated');
    }
     
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\book  $book
     * @return \Illuminate\Http\Response
     */

    public function delete($id){
        $sec = Document::join('staff','staff.id','=','documents.staff_id')->orderBy('documents.id','desc')->get();
 
        return view('document',[
            'data'=>$sec,
            'sil_id'=>$id
        ]);
    }

    public function sil($id){
        
        $con = Document::find($id)->delete();
        $staff_id = $con->staff_id; 
        $con->delete();
        
        return redirect() -> route('doc-list',$staff_id)->with('delete','Document deleted!');
    }
}