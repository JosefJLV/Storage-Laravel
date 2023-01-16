@extends('layouts.app')
@section('title')
Expenses
@endsection

@section('expense')

<h2>Expenses</h2>

@isset($sil_id)
Do u want to delete expense?<br><br>
    <a href="{{route('esil',$sil_id)}}"><button>Yes</button></a>
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
    <form method="post" action="{{route('expensesadd')}}">
        @csrf
        <b>For:</b><br>
        <input type="text" name="expense" class="form-control">
        <b>Amount:</b><br>
        <input type="text" name="amount" class="form-control"><br>
        <button type="submit" class="btn btn-success" name="add"><b>Add</b></button>
    </form>
</div>
@endempty

@isset($editdata)
<div class="alert alert-secondary">
    <form method="post" action="{{route('eupdate')}}">
        @csrf
        <b>For:</b><br>
        <input type="text" name="expense" class="form-control" value="{{$editdata->expenses}}"><br>
        <b>Amount:</b><br>
        <input type="text" name="amount" class="form-control" value="{{$editdata->amount}}"><br>
        <input type="hidden" name="id" value="{{$editdata->id}}">
        <button type="submit" class="btn btn-info" name="update">Update</button>
    </form>
</div>
@endisset

@php($i=1)
                 <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">List of Expenses</h4>
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
                                                <td><span style="font-size:16px; color:black;">{{$info->amount}}</span></td>
                                                <td><span class="badge badge-success">{{$info->created_at}}</span></td>
                                                <td><span class="badge badge-info">{{$info->updated_at}}</span></td>
                                                <td><a href="{{route('edelete',$info->id)}}"><button class="btn btn-sm btn-danger"><i style="font-size:14px;" class="fas fa-trash-alt" aria-hidden="true"></i></button></a>
                                                    <a href="{{route('eedit',$info->id)}}"><button class="btn btn-sm btn-info"><i style="font-size:14px;" class="fas fa-edit"></i></button></a>
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