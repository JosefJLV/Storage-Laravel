<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ordersRequest;
use App\Models\Orders;
use App\Models\Products;
use App\Models\Clients;
use App\Models\Brands;
use App\Models\Expense;
use Illuminate\Support\Facades\Auth;

class ordersController extends Controller
{
    public function add(ordersRequest $orders){
        $con = new Orders();
        $con->user_id = Auth::id();
        $con->client_id=$orders->client_id;
        $con->product_id=$orders->product_id;
        $con->amount=$orders->amount;
        $con->confirm='0';
        $con->save();

        return redirect()->route('orlist')->with('success','Order is added');
    } 

    public function list(){

        $sec = Orders::join('clients','clients.id','=','orders.client_id')
        ->join('products','products.id','=','orders.product_id')
        ->join('brands','brands.id','=','products.brand_id')
        ->select('orders.id','orders.user_id','orders.confirm','orders.amount AS oamount','clients.name','clients.surname','products.products','products.amount AS pamount','products.pprice','products.sprice','brands.brands')
        ->where('orders.user_id','=',Auth::id())
        ->orderBy('orders.id','desc')
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

        return view('orders',[
            'data'=>$sec,
            'cdata'=>Clients::orderBy('name','asc')
            ->where('user_id','=',Auth::id())
            ->get(),
            'pdata'=>$products,
            'bsay'=>$bsay,
            'fprofit'=>$tprod,
            'cprofit'=>$cqazanc,
            'expense'=>$expense
            ]);

    }

    public function delete($id){

        $sec = Orders::join('clients','clients.id','=','orders.client_id')
        ->join('products','products.id','=','orders.product_id')
        ->join('brands','brands.id','=','products.brand_id')
        ->select('orders.id','orders.user_id','orders.confirm','orders.amount AS oamount','clients.name','clients.surname','products.products','products.amount AS pamount','products.pprice','products.sprice','brands.brands')->
        where('orders.user_id','=',Auth::id())->orderBy('orders.id','desc')
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

        $expense = Expense::where('user_id','=',Auth::id())->sum('amount');
        
        
        $sec = Orders:: join('clients','clients.id','=','orders.client_id')
        ->join('products','products.id','=','orders.product_id')
        ->join('brands','brands.id','=','products.brand_id')
        ->select('orders.id','orders.amount AS oamount','clients.name','clients.surname','products.products','products.amount AS pamount','products.pprice','products.sprice','brands.brands')
        ->orderBy('orders.id','desc')
        ->get();        

        $bsay = Brands::where('user_id','=',Auth::id())->count();

        return view('orders',[
            'data'=>$sec,
            'cdata'=>Clients::orderBy('name','asc')->where('user_id','=',Auth::id()),
            'cdata'=>Clients::orderBy('surname','asc')->where('user_id','=',Auth::id()),
            'pdata'=>Products::join('brands','brands.id','=','products.brand_id')->where('user_id','=',Auth::id()),
            'bsay'=>$bsay,
            'cprofit'=>$cqazanc,
            'fprofit'=>$tprod,
            'expense'=>$expense,
            'product'=>products::join('brands','brands.id','=','products.brand_id')
            ->select('products.id','products.products','products.pprice','products.sprice','products.amount','brands.brands')
            ->orderBy('products.id','desc')
            ->get(),
            'sil_id'=>$id
        ]);
        
    }

    public function sil($id){
        $con=Orders::find($id)->delete();

        return redirect()->route('orlist')->with('success','Order is deleted');
    }


    public function edit($id){
        $sec1=Orders::find($id);
        $sec2=Orders::join('clients','clients.id','=','orders.client_id')
        ->join('products','products.id','=','orders.product_id')
        ->join('brands','brands.id','=','products.brand_id')
        ->select('orders.id','orders.amount AS oamount','clients.name','clients.surname','products.products','products.amount AS pamount','products.pprice','products.sprice','brands.brands')
        ->orderBy('orders.id','desc')
        ->get();

        $bsay = Brands::where('user_id','=',Auth::id())->count();

        $cqazanc = 0;
        foreach($sec2 as $o){
            $b = $o->pprice;
            $s = $o->sprice;
            $oamount = $o->oamount;
            $confirm = $o->confirm;

            if($confirm == 1)
            {$cqazanc = ($s-$b)*$oamount +$cqazanc;}
        }


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

        $expense = Expense::where('user_id','=',Auth::id())->sum('amount');


        return view('orders',[
            'editdata'=>$sec1,
            'data'=>$sec2,
            'cdata'=>Clients::orderBy('name','asc')->where('user_id','=',Auth::id())->get(),
            'cdata'=>Clients::orderBy('surname','asc')->where('user_id','=',Auth::id())->get(),
            'bsay'=>$bsay,
            'cprofit'=>$cqazanc,
            'fprofit'=>$tprod,
            'expense'=>$expense,
            'pdata'=>Products::join('brands','brands.id','=','products.brand_id')->where('products.user_id','=',Auth::id())
            ->orderBy('products.id','desc')
            ->get(),
            'bdata'=>Brands::orderBy('brands','asc')->get()

        ]);
    }
    
    public function update(ordersRequest $orders){
        $con=Orders::find($orders->id);
        $con->client_id=$orders->client_id;
        $con->product_id=$orders->product_id;
        $con->amount=$orders->amount;
        $con->save();

        return redirect()->route('orlist')->with('success','Order is updated');
    }

    public function confirm($id){

        $ocon = Orders::find($id);
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

            return redirect()->route('orlist')->with('success','Order is confirmed');

        }

        return redirect()->route('orlist')->with('success','There is no enough product to confirm this order');
    }

    public function cancel($id){

        $ocon = Orders::find($id);
        $pcon = Products::find($ocon->product_id);

            $oamount = $ocon->amount;
            $pamount = $pcon->amount;
       
            $result = $pamount + $oamount;

            $pcon->amount = $result;
            $pcon->save();
            $ocon->confirm = 0;
            $ocon->save();

            return redirect()->route('orlist')->with('success','Order is canceled');
  

    }
    

}
