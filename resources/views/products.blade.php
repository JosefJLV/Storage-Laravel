@extends('layouts.app')
@section('title')
Products
@endsection



@section('products')


@isset($sil_id)
<div class="alert alert-danger">
    <b>Do u want to delete this product?</b><br><br>
        <a href="{{route('psil',$sil_id)}}"><button class="btn btn-danger btn-sm">Yes</button></a>
        <a href="{{route('orlist')}}"><button class="btn btn-sm btn-success">No</button></a>
</div><br>
@endisset

@if($errors->any())
    @foreach($errors->all() as $sehv)
    {{$sehv}}
    @endforeach
@endif

@if(session('success'))
    <div class="text-center alert alert-success" style="font-size:20px">
        <b>{{session('success')}}</b>
    </div>
@endif

@if(session('delete'))
    <div class="text-center alert alert-danger" style="font-size:20px">
        <b>{{session('delete')}}</b>
    </div>
@endif

@if(session('update'))
    <div class="text-center alert alert-info" style="font-size:20px">
        <b>{{session('update')}}</b>
    </div>
@endif

@empty($editdata)
<div class="row">
                    <div class="col-lg-3 col-sm-6"  >
                        <div class="card">
                            <div class="stat-widget-one card-body">
                                <div class="stat-icon d-inline-block">
                                    <i class="far fa-money-bill-alt text-success border-success" style="font-size:22px;"></i>
                                </div>
                                <div class="stat-content d-inline-block">
                                    <div class="stat-text">Current/Future Profit</div>
                                    <div class="stat-digit" style="font-size:18px;">{{$cprofit}}/{{$fprofit}} <i class='fas fa-euro-sign' style='font-size:16px'></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-4">
                        <div class="card">
                            <div class="stat-widget-one card-body">
                                <div class="stat-icon d-inline-block">
                                    <i class="fas fa-user-friends text-primary border-primary" style="font-size:18px;"></i>
                                </div>
                                <div class="stat-content d-inline-block">
                                    <div class="stat-text">Clients</div>
                                    <div class="stat-digit" style="font-size:18px;">{{$cdata->count()}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card">
                            <div class="stat-widget-one card-body">
                                <div class="stat-icon d-inline-block">
                                    <i class="ti-layout-grid2 text-pink border-pink" style="font-size:18px;"></i>
                                </div>
                                <div class="stat-content d-inline-block">
                                    <div class="stat-text">Brands</div>
                                    <div class="stat-digit" style="font-size:18px;">{{$bsay}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card">
                            <div class="stat-widget-one card-body">
                                <div class="stat-icon d-inline-block">
                                    <i class="fas fa-money-check-alt text-danger border-danger" style="font-size:18px;"></i>
                                </div>
                                <div class="stat-content d-inline-block">
                                    <div class="stat-text">Expenses</div>
                                    <div class="stat-digit" style="font-size:18px;">{{$expense}} <i class='fas fa-euro-sign' style='font-size:16px'></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

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
        <b>Picture:</b><br>
        <input type="file" class="btn btn-sm" name="image"><br><br>
        <button type="submit" class="btn btn-success" name="add"><b>Add</b></button>
    </form>
</div><br>

@php($i=1)
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="badge badge-outline-dark" style="font-size:16px;">Number of products: {{$psay}}</h6>
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
                                                <td><span class="badge badge-outline-dark" style="font-size:16px; color:black;">{{$i++}}</span></td>
                                                <td>
                                                    <image style="width:65px; height:60px;" src="{{$info->images}}">
                                                </td>
                                                <td><span style="font-size:16px; color:black;">{{$info->brands}}</span></td>
                                                <td><span style="font-size:16px; color:black;">{{$info->products}}</span></td>
                                                <td><span style="font-size:16px; color:black;">{{$info->pprice}} <i class='fas fa-euro-sign' style='font-size:14px'></i></span></td>
                                                <td><span style="font-size:16px; color:black;">{{$info->sprice}} <i class='fas fa-euro-sign' style='font-size:14px'></i></span></td>
                                                <td><span style="font-size:16px; color:black;">{{$info->amount}}</span></td>
                                                <td><a href="{{route('pdelete',$info->id)}}"><button class="btn btn-sm btn-danger" title="Click to delete"><i class="fas fa-trash-alt" aria-hidden="true"></i></button></a>
                                                    <a href="{{route('pedit',$info->id)}}"><button class="btn btn-sm btn-info" title="Click to edit"><i class="fas fa-edit"></i></button></a>
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
@endempty

@isset($editdata)
<div class="alert alert-secondary">
    <form method="post" action="{{route('pupdate')}}">
        @csrf
        <b>Picture:</b><br>
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


@endsection