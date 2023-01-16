<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Staff;
use App\Models\Document;
use Storage;
use Illuminate\Support\Facades\Auth;
use Datatables;

class staffDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()) {
            return datatables()->of(Staff::where('user_id','=',Auth::id())->select('*'))
            ->addColumn('action', function($row){
            return '
                <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" title="Edit" class="edit btn btn-info edit btn-sm">
                <i class="fas fa-edit" style="font-size:16px;"></i>
                </a>
                <a href="javascript:void(0);" id="delete-book" data-toggle="tooltip" title="Delete" data-id="'.$row->id.'" class="delete btn btn-danger btn-sm">
                <i class="fas fa-trash-alt" aria-hidden="true" style="font-size:16px;"></i>
                </a>
                <a href="doc-list/'.$row->id.'" id="document" data-toggle="tooltip" title="Document" data-id="'.$row->id.'" class="document btn btn-warning btn-sm">
                <i class="fas fa-file-alt" style="font-size:16px;"></i>
                </a>';
            })
            ->addColumn('foto', function($row){
                return Storage::url($row->foto); 
                
            })
            ->addColumn('created_at', function($row){
                return date('Y-m-d H:i:s');
            })
            ->rawColumns(['action','image'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('staff-list');
    }
     
     
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {  

        $bookId = $request->id;

        if($bookId){
             
            $book = Staff::find($bookId);

            if($request->hasFile('image')){
                $path = $request->file('image')->store('public/images');
                $book->foto = $path;
            }   
         }else{
                $path = $request->file('image')->store('public/images');
               $book = new Staff;
               $book->foto = $path;
         }

        $book->user_id = Auth::id();
        $book->name = $request->name;
        $book->position = $request->position;
        $book->wage = $request->wage;
        $book->hired_at = $request->hire;
        $book->birthdate = $request->birthday;
        $book->phone = $request->phone;
        $book->save();
     
        return Response()->json($book);
    }
     
     
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {   
        $where = array('id' => $request->id);
        $book  = staff::where($where)->first();
     
        return Response()->json($book);
    }
     
     
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $book = staff::where('id',$request->id)->delete();
     
        return Response()->json($book);
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

   
    
}