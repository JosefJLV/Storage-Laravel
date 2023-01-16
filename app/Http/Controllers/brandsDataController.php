<?php

namespace App\Http\Controllers; 

use Illuminate\Http\Request;

use App\Models\Brands;
use App\Models\Products;
use App\Models\Expense;
use App\Models\Orders;
use App\Models\Clients;
use Storage; 
use Datatables;
use Illuminate\Support\Facades\Auth;


class brandsDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()) {
            return datatables()->of(Brands::where('user_id','=',Auth::id())->select('*'))
            ->addColumn('action', function($row){
                return '<a href="javascript:void(0)" data-toggle="tooltip" title="Edit"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-info btn-sm edit">
                <i class="fas fa-edit" style="font-size:16px;"></i>
            </a>
            <a href="javascript:void(0);" id="delete-book" data-toggle="tooltip" title="Delete" data-id="'.$row->id.'" class="delete btn btn-danger btn-sm">
            <i class="fas fa-trash-alt" aria-hidden="true" style="font-size:16px;"></i>
            </a>';
            })
            ->addColumn('created_at', function($row){
                return date('Y-m-d H:i:s');
            })
            ->addColumn('image', function($row){
                return Storage::url($row->image);
            })
            //->rawColumns(['action','image'])
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
        return view('brand-list',[
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

        $bookId = $request->id;

        if($bookId){
             
            $book = Brands::find($bookId);

            if($request->hasFile('image')){
                $path = $request->file('image')->store('public/images');
                $book->image = $path;
            }   
         }else{
                $path = $request->file('image')->store('public/images'); 
                $book = new Brands;
                $book->image = $path;
         }
         
        $check = Brands::where('brands',$request->title)->where('user_id','=',Auth::id())
        ->count();
        if($check == 0){
            $book->brands = $request->title; 
            $book->user_id = Auth::id();
            $book->save();
        }
        else
           {$book = 'Existing brand';}
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
        $book  = Brands::where($where)->first();
     
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
        $check = Products::where('brand_id','=',$request->id)->where('user_id','=',Auth::id())->count();
        if($check == 0){

            $book = Brands::find($request->id)->delete();   
        }
        else
            {$book = 'This brand has product in the storage';}

            return Response()->json($book); 
    }
}