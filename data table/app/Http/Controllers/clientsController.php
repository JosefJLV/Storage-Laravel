<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\clientsRequest;
use App\Models\Clients;
use App\Models\Brands;
use App\Models\Orders;
use App\Models\Products;
use App\Models\Expense;
use Illuminate\Support\Facades\Auth;

class clientsController extends Controller
{
   public function add(clientsRequest $clients){
    $yoxla = Clients::where('phone','=',$clients->phone)
    ->where('user_id','=',Auth::id())
    ->count();

    if($yoxla==0)
       { 
            $con = new Clients();
        
            $clients->validate([
                'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048|dimensions:min_width=100,min_height=100,max_width=2000,max_height=2000',
            ]);

            if($clients->file('image')){
                $file = time().'.'.$clients->image->extension();
                $clients->image->storeAs('public/uploads/clients/',$file);
                $con->image = 'storage/uploads/clients/'.$file;
            }
            $con->user_id=Auth::id();
            $con->name=$clients->cname;
            $con->surname=$clients->csurname;
            $con->phone=$clients->phone;
            $con->company=$clients->company;
            $con->save();

            return redirect()-> route('clist')->with('success','Client is added');
        }
        return redirect()-> route('clist')->with('success','This number already exists');
        
   }

   public function list(){
    $csay = Clients::where('user_id','=',Auth::id())->count();

    $sec = Clients::join('orders','orders.user_id','=','clients.user_id')
    ->join('products','products.id','=','orders.product_id')->where('products.user_id','=',Auth::id())
    ->select('clients.name','clients.surname','clients.phone','clients.company','clients.image','clients.id','clients.created_at','clients.updated_at',
                'products.sprice','products.pprice','products.amount AS pamount',
                'orders.user_id','orders.confirm','orders.amount AS oamount')
    ->where('clients.user_id','=',Auth::id())
    ->orderBy('clients.id','desc')
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


        return view('clients',[
            'data'=>$sec,
            'csay'=>$csay,
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
        $csay = Clients::where('user_id','=',Auth::id())->count();
        $sec = Clients::orderBy('id','desc')
        ->where('user_id','=',Auth::id())
        ->get();
        return view('clients',[
            'data'=>$sec,
            'sil_id'=>$id,
            'csay'=>$csay
            ]);

    }

    public function sil($id){
       $con=Clients::find($id)->delete();
       return redirect()-> route('clist')->with('success','Client is deleted');
    }

    public function edit($id){
        $csay = Clients::where('user_id','=',Auth::id())->count();
        $sec1=Clients::find($id);
        $sec2=Clients::orderBy('id','desc')
        ->where('user_id','=',Auth::id())
        ->get();
        return view('clients',[
            'editdata'=>$sec1,
            'data'=>$sec2,
            'csay'=>$csay

        ]);
      
    }

    public function update(clientsRequest $clients){
        $con = Clients::find($clients->id);
        $con->name=$clients->cname;
        $con->surname=$clients->csurname;
        $con->phone=$clients->phone;
        $con->company=$clients->company;
        $con->save();

        return redirect()-> route('clist')->with('success','Client is updated');
   }

    
}
