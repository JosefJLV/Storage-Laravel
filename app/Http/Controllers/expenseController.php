<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\expenseRequest;
use App\Models\Expense;
use App\Models\Orders;
use App\Models\Brands;
use App\Models\Clients;
use App\Models\Products;
use Illuminate\Support\Facades\Auth;

class expenseController extends Controller
{
    public function add(expenseRequest $expenses){
        $con=new Expense();
        $con->user_id = Auth::id();
        $con->expenses=$expenses->expense;
        $con->amount=$expenses->amount;
        $con->save();
        return redirect()->route('elist')->with('success','Expense successfully added');

    }
    public function list(){
        $sec = Expense::where('user_id','=',Auth::id())->orderBy('id','desc')->get();

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
            $tprod = ($sell - $buy) * $amount+$tprod;
        }

        return view('expense',[
            'data'=>$sec,
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
        $sec = Expense::orderBy('id','desc')
        ->get();

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
            $tprod = ($sell - $buy) * $amount+$tprod;
        }
        return view('expense',[
            'data'=>$sec,
            'sil_id'=>$id,
            'cdata'=>Clients::orderBy('name','asc')
            ->where('user_id','=',Auth::id()),
            'pdata'=>$products,
            'bsay'=>$bsay,
            'fprofit'=>$tprod,
            'cprofit'=>$cqazanc,
            'expense'=>$expense
        ]);
    }

    public function sil($id){
        $con=Expense::find($id)->delete();
        return redirect()->route('elist')->with('delete','Expense successfully deleted');
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
        return redirect()->route('elist')->with('update','Expense successfully updated');

    }
}
