<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\brandsRequest;
use App\Models\Brands;
use App\Models\Orders;
use App\Models\Products;
use App\Models\Clients;
use App\Models\Expense;
use Illuminate\Support\Facades\Auth;

class brandsController extends Controller
{
    

    public function add(brandsRequest $brands) {

        $yoxla = Brands::where('brands','=',$brands->brands)
        ->where('user_id','=',Auth::id())
        ->count();

        if($yoxla==0)
        {
            $con = new Brands(); 

            $brands->validate([
                                'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048|dimensions:min_width=100,min_height=100,max_width=2000,max_height=2000',
                            ]);

            if($brands->file('image')){

                $file = time().'.'.$brands->image->extension();
                $brands->image->storeAs('public/uploads/brands/',$file);
                $con->image = 'storage/uploads/brands/'.$file;
            }

            $con->brands = $brands->brands;
            $con->user_id = Auth::id();
            $con->save();
            return redirect()-> route('blist')->with('success','Brand is added!');
        }
        return redirect()-> route('blist')->with('exist','This brand already exists!');

    }

    public function list(){
        $bsay = Brands::where('user_id','=',Auth::id())->count();

        $sec = Brands::join('orders','orders.user_id','=','brands.user_id')->where('orders.user_id','=',Auth::id())
        ->join('products','products.id','=','orders.product_id')->where('products.user_id','=',Auth::id())
        ->select('brands.id','brands.user_id','brands.image','brands.brands','brands.created_at','brands.updated_at',
                    'orders.user_id','orders.confirm','orders.amount AS oamount',
                    'products.products','products.amount AS pamount','products.pprice','products.sprice')
        ->where('brands.user_id','=',Auth::id())
        
        ->orderBy('brands.id','desc')
        ->get();

        $cqazanc = 0;
        foreach($sec as $o){
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
            $tprod = ($sell - $buy) * $amount+$tprod;
        }

        return view('brands',[
            'data'=>$sec,
            'bsay'=>$bsay,
            'cdata'=>Clients::orderBy('name','asc')
            ->where('user_id','=',Auth::id()),
            'pdata'=>$products,
            'bsay'=>$bsay,
            'fprofit'=>$tprod,
            'cprofit'=>$cqazanc,
            'expense'=>$expense
        ]);
    }
    public function delete($id){
        $bsay = Brands::where('user_id','=',Auth::id())->count();
        $sec = Brands::orderBy('id','desc')->where('user_id','=',Auth::id())->get();
        return view('brands',[
            'data'=>$sec,
            'sil_id'=>$id,
            'bsay'=>$bsay
        ]);
    }


    public function sil($id){
        $con = Brands::find($id)->delete();
        return redirect()-> route('blist')->with('delete','Brand is deleted!');
    }

    public function edit($id){
        $bsay = Brands::where('user_id','=',Auth::id())->count();
        $sec1 = Brands::find($id);
        $sec2 = Brands::orderBy('id','desc')->where('user_id','=',Auth::id())->get();
        return view('brands',[
            'editdata'=>$sec1,
            'data'=>$sec2,
            'bsay'=>$bsay
        ]);
    }

    public function update(brandsRequest $brands) {
        $con = Brands::find($brands->id);

        if($brands->file('image')){
            $file = time().'.'.$brands->image->extension();
            $brands->image->storeAs('public/uploads/brands/',$file);
            $con->image = 'storage/uploads/brands/'.$file;
        }
        $con->brands = $brands->brands;
        $con->save();
        return redirect()-> route('blist')->with('update',' Brand is updated!');


    }

   
}
