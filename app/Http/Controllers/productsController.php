<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\productsRequest;
use App\Models\Products;
use App\Models\Orders;
use App\Models\Clients;
use App\Models\Expense;
use App\Models\Brands;
use Illuminate\Support\Facades\Auth;

class productsController extends Controller
{
    public function add(productsRequest $products){
        $con = new Products();
        $products->validate([
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048|dimensions:min_width=100,min_height=100,max_width=2000,max_height=2000',
        ]);
        if($products->file('image')){
            $file = time().'.'.$products->image->extension();
            $products->image->storeAs('public/uploads/products/',$file);
            $con->images = 'storage/uploads/products/'.$file;
        }
        $con->user_id=Auth::id();
        $con->brand_id=$products->brand_id; 
        $con->products=$products->pname;
        $con->pprice=$products->pprice;
        $con->sprice=$products->sprice;
        $con->amount=$products->amount;
        $con->save();
        return redirect()->route('plist')->with('success','Product successfully added'); 
    }

    public function list(){    
        $psay = Products::where('user_id','=',Auth::id())->count();
        
        $sec = Products::where('products.user_id','=',Auth::id())
        ->join('brands','brands.id','=','products.brand_id')
        ->select('products.id','products.products','products.pprice','products.sprice','products.amount','brands.brands','products.images')
        ->orderBy('products.id','desc')
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

        return view('products',[
            'data'=>$sec,
            'psay'=>$psay,
            'bdata'=>Brands::where('user_id','=',Auth::id())->orderBy('brands','asc')->get(),
            'cdata'=>Clients::orderBy('name','asc')
            ->where('user_id','=',Auth::id())->get(),
            'pdata'=>$products,
            'bsay'=>$bsay,
            'fprofit'=>$tprod,
            'cprofit'=>$cqazanc,
            'expense'=>$expense
            
        ]);
    }

    public function delete($id){
        $psay = Products::where('user_id','=',Auth::id())->count();
        $sec = Products::join('brands','brands.id','=','products.brand_id')->where('brands.user_id','=',Auth::id())
        ->select('products.id','products.products','products.pprice','products.sprice','products.amount','brands.brands')
        ->orderBy('products.id','desc')
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


        return view('products',[
            'data'=>$sec,
            'psay'=>$psay,
            'bdata'=>Brands::orderBy('brands','asc')
            ->where('user_id','=',Auth::id())
            ->get(),
            'sil_id'=>$id,
            'cdata'=>Clients::orderBy('name','asc')
            ->where('user_id','=',Auth::id())->get(),
            'pdata'=>$products,
            'bsay'=>$bsay,
            'fprofit'=>$tprod,
            'cprofit'=>$cqazanc,
            'expense'=>$expense
        ]);

    }

    public function sil($id){
        $check = Products::join('orders','orders.product_id','=','products.id')->where('products.user_id',Auth::id())->count();
        if($check == 0){
            $con=Products::find($id)->delete();
            return redirect()->route('plist')->with('delete','Product successfully deleted');
        }
        return redirect()->route('plist')->with('delete','This product is ordered');
    }

    public function edit($id){
        $psay = Products::where('user_id','=',Auth::id())->count();
        $sec1 = Products::find($id);
        $sec2 = Products::join('brands','brands.id','=','products.brand_id')
        ->select('products.id','products.products','products.pprice','products.sprice','products.amount','products.images','brands.brands')
        ->orderBy('products.id','desc')
        ->get();
        return view('products',[
            'editdata'=>$sec1,
            'data'=>$sec2,
            'psay'=>$psay,
            'bdata'=>Brands::orderBy('brands','asc')
            ->where('user_id','=',Auth::id())
            ->get()
        ]);
    }
    public function update(productsRequest $products){
        $con = Products::find($products->id);
        $con->brand_id=$products->brand_id;
        $con->products=$products->pname;
        $con->pprice=$products->pprice;
        $con->sprice=$products->sprice;
        $con->amount=$products->amount;
        $con->save();
        return redirect()->route('plist')->with('update','Product successfully updated');
    }
    
}
