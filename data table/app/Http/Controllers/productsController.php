<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\productsRequest;
use App\Models\Products;
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
        return redirect()->route('plist')->with('success','Product is added');
    }

    public function list(){    
        $psay = Products::where('user_id','=',Auth::id())->count();
        $sec = Products::where('products.user_id','=',Auth::id())
        ->join('brands','brands.id','=','products.brand_id')
        ->select('products.id','products.products','products.pprice','products.sprice','products.amount','brands.brands','products.images')
        ->orderBy('products.id','desc')
        ->get(); 

        return view('products',[
            'data'=>$sec,
            'psay'=>$psay,
            'bdata'=>Brands::orderBy('brands','asc')
            ->where('user_id','=',Auth::id())
            ->get()
        ]);
    }

    public function delete($id){
        $psay = Products::where('user_id','=',Auth::id())->count();
        $sec = Products::join('brands','brands.id','=','products.brand_id')->where('brands.user_id','=',Auth::id())
        ->select('products.id','products.products','products.pprice','products.sprice','products.amount','brands.brands')
        ->orderBy('products.id','desc')
        ->get();


        return view('products',[
            'data'=>$sec,
            'psay'=>$psay,
            'bdata'=>Brands::orderBy('brands','asc')
            ->where('user_id','=',Auth::id())
            ->get(),
            'sil_id'=>$id
        ]);

    }

    public function sil($id){
        $con=Products::find($id)->delete();
        return redirect()->route('plist')->with('success','Product is deleted');

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
        return redirect()->route('plist')->with('success','Product is updated');
    }
    
}
