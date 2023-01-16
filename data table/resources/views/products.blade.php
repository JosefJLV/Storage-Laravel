@extends('layouts.app')
@section('title')
Products
@endsection



@section('products')


<h2>Products</h2>

@isset($sil_id)
Do u want to delete this product?<br><br>
    <a href="{{route('psil',$sil_id)}}"><button>Yes</button></a>
    <a href="{{route('orlist')}}"><button>No</button></a>
    <br><br>
@endisset

@if($errors->any())

    @foreach($errors->all() as $sehv)
    {{$sehv}}
    @endforeach
@endif
@if(session('success'))
    {{session('success')}}
@endif

@empty($editdata)
<div class="alert alert-info">
    <form method="post" action="{{route('productsadd')}}" enctype="multipart/form-data">
        @csrf
        <b>Brand:</b><br>
        <select name="brand_id" class="form-control">
            <option value="">Choose</option>
            @foreach($bdata as $binfo)
                <option value="{{$binfo->id}}">{{$binfo->brands}}</option>
            @endforeach
        </select>
        <b>Name of product:</b><br>
        <input type="text" name="pname" class="form-control">
        <b>Purchase price:</b><br>
        <input type="text" name="pprice" class="form-control">
        <b>Sale price:</b><br> 
        <input type="text" name="sprice" class="form-control">
        <b>Amount:</b><br>
        <input type="text" name="amount" class="form-control">
        <b>Logo:</b><br>
        <input type="file" class="btn btn-sm" name="image"><br><br>
        <button type="submit" class="btn btn-success" name="add"><b>Add</b></button>
    </form>
</div><br>
@endempty

@isset($editdata)
<div class="alert alert-secondary">
    <form method="post" action="{{route('pupdate')}}">
        @csrf
        <b>Logo:</b><br>
        <image style="width:65px; height:65px;" src="{{url($editdata->images)}}">
        <input type="file" class="btn btn-sm" name="image"><br>
        <b>Brand:</b><br>
        <select name="brand_id" class="form-control">
            <option value="">Choose</option>
            @foreach($bdata as $binfo)
                @if($binfo->id==$editdata->brand_id)
                <option selected value="{{$binfo->id}}">{{$binfo->brands}}</option>
                @else
                <option value="{{$binfo->id}}">{{$binfo->brands}}</option>
                @endif
            @endforeach
        </select>
        <b>Name of product:</b><br>
        <input type="text" name="pname" class="form-control" value="{{$editdata->products}}">
        <b>Purchase price:</b><br>
        <input type="text" name="pprice" class="form-control" value="{{$editdata->pprice}}">
        <b>Sale price:</b><br>
        <input type="text" name="sprice" class="form-control" value="{{$editdata->sprice}}">
        <b>Amount:</b><br>
        <input type="text" name="amount" class="form-control" value="{{$editdata->amount}}">
        <input type="hidden" name="id" value="{{$editdata->id}}"><br>
        <button type="submit" name="update" class="btn btn-info">Update</button>
    </form>
</div><br>
@endisset

@php($i=1)
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Number of Products:{{$psay}}</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table mb-0 table-sm">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Logo</th>
                                                <th>Brand</th>
                                                <th>Product</th>
                                                <th>Purchase price</th>
                                                <th>Sale price</th>
                                                <th>Amount</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($data as $info)
                                            <tr>
                                                <td><span style="font-size:16px; color:black;">{{$i++}}</span></td>
                                                <td>
                                                    <image style="width:65px; height:60px;" src="{{$info->images}}">
                                                </td>
                                                <td><span style="font-size:16px; color:black;">{{$info->brands}}</span></td>
                                                <td><span style="font-size:16px; color:black;">{{$info->products}}</span></td>
                                                <td><span style="font-size:16px; color:black;">{{$info->pprice}}</span></td>
                                                <td><span style="font-size:16px; color:black;">{{$info->sprice}}</span></td>
                                                <td><span style="font-size:16px; color:black;">{{$info->amount}}</span></td>
                                                <td><a href="{{route('pdelete',$info->id)}}"><button class="btn btn-sm btn-danger"><i class="fas fa-trash-alt" aria-hidden="true"></i></button></a>
                                                    <a href="{{route('pedit',$info->id)}}"><button class="btn btn-sm btn-info"><i class="fas fa-edit"></i></button></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
@endsection