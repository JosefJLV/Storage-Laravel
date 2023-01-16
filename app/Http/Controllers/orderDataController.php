<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orders;
use App\Models\Clients;
use App\Models\Products;
use App\Models\Brands;
use App\Models\Expense;
use DB;
use Storage;
use Datatables;
use Illuminate\Support\Facades\Auth;

class orderDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()) {
            return datatables()->of(Orders::join('clients','clients.id','=','orders.client_id') 
            ->join('products','products.id','=','orders.product_id')
            ->join('brands','brands.id','=','products.brand_id')
            ->where('orders.user_id','=',Auth::id())
            ->select('orders.id','orders.user_id','orders.confirm','orders.amount AS oamount',DB::raw("CONCAT(clients.name,' ',clients.surname) AS name"),DB::raw("CONCAT(brands.brands,' ','[',products.products,']') AS products"),'products.amount AS pamount','products.pprice','products.sprice',)
            ->orderBy('orders.id','desc')
            ->get())
            ->addColumn('action', function($row){ 
                if($row->confirm == 0){
                    return'
                    <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" title="Edit" class="edit btn-sm btn btn-info edit">
                    <i class="fas fa-edit" style="font-size:16px;"></i>
                    </a>
                    <a href="javascript:void(0);" id="delete-book" data-toggle="tooltip" title="Delete" data-id="'.$row->id.'" class="delete btn-sm btn btn-danger">
                    <i class="fas fa-trash-alt" aria-hidden="true" style="font-size:16px;"></i>
                    </a>
                    <a href="javascript:void(0);" id="delete-book" data-toggle="tooltip" title="Confirm" data-id="'.$row->id.'" class="confirm btn-sm btn btn-success">
                    <i class="fas fa-check" style="font-size:16px;"></i>
                    </a>';}
                    
                    else{
                    return'
                    <a href="javascript:void(0);" id="delete-book" data-toggle="tooltip" title="Cancel" data-id="'.$row->id.'" class="cancel btn-sm btn btn-warning">
                    <i class="fas fa-times" style="font-size:16px;"></i>
                    </a>'; 
                }

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
        return view('orders-list',[
            'bsay'=>$bsay,
            'bsay'=>$bsay,
            'fprofit'=>$tprod,
            'cprofit'=>$cqazanc,
            'expense'=>$expense,
            'cdata'=>Clients::where('user_id','=',Auth::id())->orderBy('name','asc')->get(),
            'pdata'=>Products::where('products.user_id','=',Auth::id())->join('brands','brands.id','products.brand_id')->select('products.id','products.products','products.pprice','products.sprice','products.amount','brands.brands')
            ->orderBy('products.id','desc') 
            ->get()
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
        {$book = Orders::find($id);}
        else
        {$book = new Orders();}
         
        $book->user_id = Auth::id();
        $book->client_id = $request->client_id;
        $book->product_id = $request->product_id;
        $book->amount = $request->amount;
        $book->confirm = 0;

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
        $book  = Orders::where($where)->first();
     
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
        $book = Orders::where('id',$request->id)->delete();
     
        return Response()->json($book);
    }


    public function tesdiq(Request $request)
    {
        $ocon = Orders::find($request->id);
        $pcon = Products::find($ocon->product_id);

        $oamount = $ocon->amount;
        $pamount = $pcon->amount;

        if($oamount<=$pamount)
        {
            $result = $pamount - $oamount;

            $pcon->amount = $result;
            $pcon->save();
            $ocon->confirm = 1;
            $ocon->save();
        }
        else
        {$ocon = 'There is no enough product to confirm this order';}

        return Response()->json($ocon);
    }

    public function cancel (request $request){
        $ocon = Orders::find($request->id);
        $pcon = Products::find($ocon->product_id);

            $oamount = $ocon->amount;
            $pamount = $pcon->amount;
       
            $result = $pamount + $oamount;

            $pcon->amount = $result;
            $pcon->save();
            $ocon->confirm = 0;
            $ocon->save();
            return Response()->json($ocon);
    }
}