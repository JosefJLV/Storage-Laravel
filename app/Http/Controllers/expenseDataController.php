<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Expense;
use App\Models\Clients;
use App\Models\Brands;
use App\Models\Products;
use App\Models\Orders;

use Datatables;

use Illuminate\Support\Facades\Auth;

class expenseDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() 
    {
        if(request()->ajax()) {
            return datatables()->of(Expense::where('user_id','=',Auth::id())->select('*'))
            ->addColumn('action', function($row){
                return '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" title="Edit" class="edit btn-sm btn btn-info edit">
                <i style="font-size:16px;" class="fas fa-edit"></i>
            </a>
            <a href="javascript:void(0);" id="delete-book" data-toggle="tooltip" title="Delete" data-id="'.$row->id.'" class="delete btn-sm btn btn-danger">
            <i style="font-size:16px;" class="fas fa-trash-alt" aria-hidden="true"></i>
            </a>';
            })
            ->addColumn('created_at', function($row){
                return date('Y-m-d H:i:s');
            })
            ->addIndexColumn()
            ->make(true);
        }

        $sec1 = Orders::join('clients','clients.id','=','orders.client_id')
        ->join('products','products.id','=','orders.product_id')
        ->join('brands','brands.id','=','products.brand_id')
        ->select('orders.id','orders.user_id','orders.confirm','orders.amount AS oamount','clients.name','clients.surname','products.products','products.amount AS pamount','products.pprice','products.sprice','brands.brands')
        ->where('orders.user_id','=',Auth::id())
        ->orderBy('orders.id','desc')
        ->get();

        $cqazanc = 0;
        foreach($sec1 as $o){
            $b = $o->pprice;
            $s = $o->sprice;
            $oamount = $o->oamount;
            $confirm = $o->confirm;

            if($confirm == 1)
            {$cqazanc = ($s-$b)*$oamount +$cqazanc;}
        }

        $bsay = Brands::where('user_id','=',Auth::id())->count();

        $expense = Expense::where('user_id','=',Auth::id())->sum('amount');

        $products = Products::join('brands','brands.id','=','products.brand_id')->where('products.user_id','=',Auth::id())
        ->select('products.id','products.products','products.pprice','products.sprice','products.amount','brands.brands')
        ->orderBy('products.id','desc') 
        ->get();


        $tprod = 0;

        foreach($products as $p){
            $buy = $p->pprice;
            $sell = $p->sprice;
            $amount = $p->amount;
            $tprod = ($sell-$buy)*$amount+$tprod;
        }
        return view('expense-list',[
            'bsay'=>$bsay,
            'cdata'=>Clients::orderBy('name','asc')->where('user_id','=',Auth::id()),
            'pdata'=>$products,
            'bsay'=>$bsay,
            'fprofit'=>$tprod,
            'cprofit'=>$cqazanc,
            'expense'=>$expense
        ]);
    }
     
     
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {  
        $id = $request->id;

        if($id)
        {$book = Expense::find($id);}
        else
        {$book = new Expense();}
         
        $book->expenses = $request->title;
        $book->amount = $request->code;
        $book->user_id = Auth::id();
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
        $book  = Expense::where($where)->first();
     
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
        $book = Expense::where('id',$request->id)->delete();
     
        return Response()->json($book);
    }
}