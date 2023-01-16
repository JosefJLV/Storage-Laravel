<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

use Datatables;
use Storage;

use Illuminate\Support\Facades\Hash;

class userDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()) {
            return datatables()->of(User::get())
            ->addColumn('action', function($row){
                if($row->block == 0){
                return '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" title="Edit" class="edit btn-sm btn btn-info edit">
                <i style="font-size:16px;" class="fas fa-edit"></i>
                </a>
                <a href="javascript:void(0);" id="delete-book" data-toggle="tooltip" title="Delete" data-id="'.$row->id.'" class="delete btn-sm btn btn-warning">
                <i style="font-size:16px;" class="fas fa-trash-alt" aria-hidden="true"></i>
                </a>
                <a href="javascript:void(0);" id="delete-book" data-toggle="tooltip" title="Block" data-id="'.$row->id.'" class="block btn-sm btn btn-danger">
                <i style="font-size:16px;" class="fas fa-user-lock" aria-hidden="true"></i>
                </a>';}

                else{
                    return '
                    <a href="javascript:void(0);" id="delete-book" data-toggle="tooltip" data-original-title="Unblock" data-id="'.$row->id.'" class="unblock btn-sm btn btn-success">
                    <i style="font-size:16px;" class="fas fa-times" aria-hidden="true"></i>
                    </a>';
            }
            })
            ->addColumn('created_at', function($row){
                return date('Y-m-d H:i:s');
            })
            ->addColumn('foto', function($row){
                return Storage::url($row->foto);
                
            })
            ->addIndexColumn()
            ->make(true);
        }
        return view('user-list');
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
             
                    $book = User::find($bookId);

                    if($request->hasFile('image')){
                        $path = $request->file('image')->store('public/images');
                        $book->foto = $path;
                    }
                    
                    if(empty($request->npassword))
            {
                if(Hash::check($request->password,$book->password))
                {
                    $book->block = 0;
                    $book->name = $request->name;
                    $book->email = $request->email;
                    $book->password = Hash::make($request->password);
                    $book->save();
                }
                else{
                    return redirect()->route('user-list')->with('wrong','Wrong password');
                }
            }
            else{
                $book->block = 0;
                    $book->name = $request->name;
                    $book->email = $request->email;
                    $book->password = Hash::make($request->npassword);
                    $book->save();

            }

                }else{
                    $path = $request->file('image')->store('public/images'); 
                    $book = new User;
                    $book->foto = $path;


                    $book->block = 0;
                    $book->name = $request->name;
                    $book->email = $request->email;
                    $book->password = Hash::make($request->password);
                    $book->save();
            
                    
        }



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
        $book  = User::where($where)->first();
        
        
     
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
        $book = User::where('id',$request->id)->delete();
     
        return Response()->json($book);
    }

    public function block(Request $request){
        $con = User::find($request->id);

        $con->block = 1;
        $con->save();

        return Response()->json($book);
    }

    public function unblock(Request $request){
        $con = User::find($request->id);

        $con->block = 0;
        $con->save();

        return Response()->json($book);
    }
}