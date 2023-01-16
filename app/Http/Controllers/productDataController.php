<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Brands;
use App\Models\Orders;
use App\Models\Expense;
use App\Models\Clients;
use Datatables;
use Illuminate\Support\Facades\Auth;
use Storage;

class productDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */ 
    public function index()
    {
        if(request()->ajax()) {
            return datatables()->of(Products::where('products.user_id','=',Auth::id())
            ->join('brands','brands.id','=','products.brand_id')
            ->select('products.id','products.products','products.pprice','products.sprice','products.amount','brands.brands','products.images')
            ->orderBy('products.id','desc')
            ->get())
            ->addColumn('action', function($row){
                return '
                <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" title="Edit" class="edit btn btn-info btn-sm edit">
                <i class="fas fa-edit" style="font-size:16px;" ></i>
                </a>
                <a href="javascript:void(0);" id="delete-book" data-toggle="tooltip" title="Delete" data-id="'.$row->id.'" class="delete btn btn-danger btn-sm">
                <i class="fas fa-trash-alt" aria-hidden="true" style="font-size:16px;" ></i>
                </a>';
            })
            ->addColumn('images', function($row){
                return Storage::url($row->images);
                
            })
            //->rawColumns(['action','image'])
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
        return view('product-list',[
            'bsay'=>$bsay,
            'cdata'=>Clients::orderBy('name','asc')->where('user_id','=',Auth::id()),
            'pdata'=>$products,
            'bsay'=>$bsay,
            'fprofit'=>$tprod,
            'cprofit'=>$cqazanc,
            'expense'=>$expense,
            'bdata'=>Brands::where('user_id','=',Auth::id())->orderBy('brands','asc')->get()
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

        $bookId = $request->id;

        if($bookId){
             
            $book = Products::find($bookId);

            if($request->hasFile('image')){
                $path = $request->file('image')->store('public/images');
                $book->images = $path;
            }   
         }else{
                $path = $request->file('image')->store('public/images');
                $book = new Products;
                $book->images = $path;
         }
            $book->brand_id = $request->brand_id;
            $book->products = $request->product; 
            $book->pprice = $request->pprice;
            $book->sprice = $request->sprice;
            $book->amount = $request->amount;
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
        $book  = Products::where($where)->first();
     
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
        $check = Orders::where('product_id','=',$request->id)->where('user_id','=',Auth::id())->count();
        if($check == 0)
            {$book = Products::find($request->id)->delete();}
        else
            {$book = 'This product has already ordered';}
     
        return Response()->json($book);
    }
}