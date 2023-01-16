@extends('layouts.app')
@section('title')
Orders
@endsection

@section('orders')



@isset($sil_id)
    Do u want to delete this order?<br><br>
    <a href="{{route('sil',$sil_id)}}"><button>Yes</button></a>
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
    <form method="post" action="{{route('oradd')}}">
        @csrf
        <b>Clients:</b><br>
        <select name="client_id" class="form-control">
            <option value="">Choose the client</option>
            @foreach($cdata as $cinfo)
            <option value="{{$cinfo->id}}">{{$cinfo->name}} {{$cinfo->surname}}</option>
            @endforeach
        </select>

        <b>Products:</b><br>
        <select name="product_id" class="form-control">
            <option value="">Choose the product</option>
            @foreach($pdata as $pinfo)
            <option value="{{$pinfo->id}}">{{$pinfo->brands}} - {{$pinfo->products}} [{{$pinfo->amount}}]</option>
            @endforeach
        </select>

        <b>Amount:</b><br>
        <input type="text" name="amount" class="form-control"><br>
        <button type="submit" class="btn btn-success" name="add"><b>Add</b></button>
    </form>
</div>
@endempty

@isset($editdata)
<div class="alert alert-secondary">
    <form method="post" action="{{route('oupdate')}}">
        @csrf
        Clients:<br>
        <select name="client_id" class="form-control">
            <option value="">Choose the client</option>
            @foreach($cdata as $cinfo)
                @if($cinfo->id==$editdata->client_id)
                    <option selected value="{{$cinfo->id}}">{{$cinfo->name}} {{$cinfo->surname}}</option>
                    @else
                    <option value="{{$cinfo->id}}">{{$cinfo->name}} {{$cinfo->surname}}</option>
                @endif
            @endforeach
        </select><br>

        Products:<br>
        <select name="product_id" class="form-control">
            <option value="">Choose the product</option>
            @foreach($pdata as $pinfo)
                @if($pinfo->id==$editdata->product_id)
                    <option selected value="{{$pinfo->id}}">{{$pinfo->brands}} - {{$pinfo->products}} [{{$pinfo->amount}}]</option>
                @endif
            @endforeach
        </select><br>

        Amount:<br>
        <input type="text" name="amount" class="form-control" value="{{$editdata->amount}}"><br>
        <input type="hidden" name="id" value="{{$editdata->id}}">
        <button type="submit" class="btn btn-secondary" name="update">Update</button>
    </form>
</div>
@endisset
                <div class="row">
                    <div class="col-lg-3 col-sm-6"  >
                        <div class="card">
                            <div class="stat-widget-one card-body">
                                <div class="stat-icon d-inline-block">
                                    <i class="ti-money text-success border-success" style="font-size:18px;"></i>
                                </div>
                                <div class="stat-content d-inline-block">
                                    <div class="stat-text">Current/Future Profit</div>
                                    <div class="stat-digit" style="font-size:18px;">{{$cprofit}}/{{$fprofit}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-4">
                        <div class="card">
                            <div class="stat-widget-one card-body">
                                <div class="stat-icon d-inline-block">
                                    <i class="ti-user text-primary border-primary" style="font-size:18px;"></i>
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
                                    <i class="ti-link text-danger border-danger" style="font-size:18px;"></i>
                                </div>
                                <div class="stat-content d-inline-block">
                                    <div class="stat-text">Expenses</div>
                                    <div class="stat-digit" style="font-size:18px;">{{$expense}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

@php($i=1)
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">List of Orders</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table mb-0 table-sm">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th style="font-size:12px; color:blue;">Client</th>
                                                <th style="font-size:12px; color:blue;">Product</th>
                                                <th style="font-size:12px; color:blue;">Buy</th>
                                                <th style="font-size:12px; color:blue;">Sell</th>
                                                <th style="font-size:12px; color:blue;">Stock</th>
                                                <th style="font-size:12px; color:blue;">Order</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($data as $info)
                                            <tr>
                                                <td><span style="font-size:16px;">{{$i++}}</span></td>
                                                <td><span style="font-size:16px; color:black;">{{$info->name}} {{$info->surname}}</span></td>
                                                <td><span style="font-size:16px; color:black;">{{$info->brands}}/{{$info->products}}</span></td>
                                                <td><span style="font-size:16px; color:black;">{{$info->pprice}}</span></td>
                                                <td><span style="font-size:16px; color:black;">{{$info->sprice}}</span></td>
                                                <td><span style="font-size:16px; color:black;">{{$info->pamount}}</span></td>
                                                <td><span style="font-size:16px; color:black;">{{$info->oamount}}</span></td>
                                                <td>
                                                    @if($info->confirm=="0")
                                                        <a href="{{route('odelete',$info->id)}}"><button class="btn btn-sm btn-danger"><i class="fas fa-trash-alt" aria-hidden="true"></i></button></a>
                                                        <a href="{{route('oedit',$info->id)}}"><button class="btn btn-sm btn-info"><i class="fas fa-edit"></i></button></a>
                                                        <a href="{{route('confirm',$info->id)}}"><button class="btn btn-sm btn-success"><i class="fas fa-check"></i></button></a><br><br>
                                                    @endif
                                                    @if($info->confirm=="1")
                                                        <a href="{{route('cancel',$info->id)}}"><button class="btn btn-sm btn-warning"><i class="fas fa-times"></i></button></a><br><br>
                                                    @endif
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