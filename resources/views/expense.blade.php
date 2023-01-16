@extends('layouts.app')
@section('title')
Expenses
@endsection

@section('expense')


@isset($sil_id)
<div class="alert alert-danger">
    <b>Do u want to delete expense?</b><br><br>
        <a href="{{route('esil',$sil_id)}}"><button class="btn btn-danger btn-sm">Yes</button></a>
        <a href="{{route('orlist')}}"><button class="btn btn-success btn-sm">No</button></a>
</div>
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
    <form method="post" action="{{route('expensesadd')}}">
        @csrf
        <b>For:</b><br>
        <input type="text" name="expense" class="form-control">
        <b>Amount:</b><br>
        <input type="text" name="amount" class="form-control"><br>
        <button type="submit" class="btn btn-success" name="add"><b>Add</b></button>
    </form>
</div>

    @php($i=1)
                 <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="badge badge-outline-dark" style="font-size:16px;">List of expenses</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table mb-0 table-sm">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th style="font-size:12px; color:blue;">Expense</th>
                                                <th style="font-size:12px; color:blue;">Amount</th>
                                                <th style="font-size:12px; color:blue;">Added at</th>
                                                <th style="font-size:12px; color:blue;">Updated at</th>
                                                <th style="font-size:12px; color:blue;"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($data as $info)
                                            <tr>
                                                <td><span class="badge badge-outline-dark" style="font-size:15px;">{{$i++}}</span></td>
                                                <td><span style="font-size:16px; color:black;">{{$info->expenses}}</span></td>
                                                <td><span style="font-size:16px; color:black;">{{$info->amount}} <i class='fas fa-euro-sign' style='font-size:14px'></i></span></td>
                                                <td><span class="badge badge-success">{{$info->created_at}}</span></td>
                                                <td><span class="badge badge-info">{{$info->updated_at}}</span></td>
                                                <td><a href="{{route('edelete',$info->id)}}"><button class="btn btn-sm btn-danger" title="Click to delete"><i style="font-size:14px;" class="fas fa-trash-alt" aria-hidden="true"></i></button></a>
                                                    <a href="{{route('eedit',$info->id)}}"><button class="btn btn-sm btn-info" title="Click to edit"><i style="font-size:14px;" class="fas fa-edit"></i></button></a>
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
    <form method="post" action="{{route('eupdate')}}">
        @csrf
        <b>For:</b><br>
        <input type="text" name="expense" class="form-control" value="{{$editdata->expenses}}">
        <b>Amount:</b><br>
        <input type="text" name="amount" class="form-control" value="{{$editdata->amount}}"><br>
        <input type="hidden" name="id" value="{{$editdata->id}}">
        <button type="submit" class="btn btn-info" name="update">Update</button>
    </form>
</div>
@endisset



@endsection