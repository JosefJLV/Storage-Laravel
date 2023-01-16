<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\expenseRequest;
use App\Models\Expense;
use Illuminate\Support\Facades\Auth;

class expenseController extends Controller
{
    public function add(expenseRequest $expenses){
        $con=new Expense();
        $con->user_id = Auth::id();
        $con->expenses=$expenses->expense;
        $con->amount=$expenses->amount;
        $con->save();
        return redirect()->route('elist')->with('success','Expense is added');

    }
    public function list(){
        $sec = Expense::where('user_id','=',Auth::id())->orderBy('id','desc')->get();
        return view('expense',[
            'data'=>$sec
        ]);
    }
    public function delete($id){
        $sec = Expense:: orderBy('id','desc')
        ->get();
        return view('expense',[
            'data'=>$sec,
            'sil_id'=>$id
        ]);
    }

    public function sil($id){
        $con=Expense::find($id)->delete();
        return redirect()->route('elist')->with('success','Expense is deleted');
    }

    public function edit($id){
        $sec1=Expense::find($id);
        $sec2=Expense:: orderBy('id','desc')->get();
        return view('expense',[
            'editdata'=>$sec1,
            'data'=>$sec2
        ]);
        
    }

    public function update(expenseRequest $expenses){
        $con= Expense::find($expenses->id);
        $con->expenses=$expenses->expense;
        $con->amount=$expenses->amount;
        $con->save();
        return redirect()->route('elist')->with('success','Expense is updated');

    }
}
