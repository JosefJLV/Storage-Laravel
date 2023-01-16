@extends('layouts.app')
@section('title')
Clients
@endsection

@section('clients')

@isset($sil_id)
Do u want to delete this client?<br><br>
    <a href="{{route('csil',$sil_id)}}"><button>Yes</button></a>
    <a href="{{route('clist')}}"><button>No</button></a>
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

@empty($editdata)
<div class="alert alert-info">
        <form method="post" action="{{route('clientsadd')}}" enctype="multipart/form-data">
            @csrf
            <b>Name:</b><br>
            <input type="text" name="cname" class="form-control">
            <b>Surname:</b><br>
            <input type="text" name="csurname" class="form-control">
            <b>Phone:</b><br>
            <input type="text" name="phone" class="form-control">
            <b>Company:</b><br>
            <input type="text" name="company" class="form-control">
            <b>Logo:</b><br>
            <input class="btn btn-sm" type="file" name="image"><br><br>
            <button type="submit" name="add" class="btn btn-success"><b>Add</b></button>
        </form>
</div>
@endempty

@isset($editdata)
<div class="alert alert-info">
    <form method="post" action="{{route('cupdate')}}">
        @csrf
        <b>Name</b><br>
        <input type="text" name="cname" class="form-control" value="{{$editdata->name}}"><br>
        <b>Surname</b><br>
        <input type="text" name="csurname" class="form-control" value="{{$editdata->surname}}"><br>
        <b>Phone</b><br>
        <input type="text" name="phone" class="form-control" value="{{$editdata->phone}}"><br>
        <b>Company</b><br>
        <input type="text" name="company" class="form-control" value="{{$editdata->company}}"><br>
        <input type="hidden" name="id" value="{{$editdata->id}}"> 
        <button type="submit" class="btn btn-primary" name="update"><b>Update</b></button>
    </form>
</div>
@endisset
              <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Number of Clients:{{$csay}}</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table student-data-table m-t-20 table-sm">
                                        <thead>
                                            <tr>
                                                <th>Logo</th>
                                                <th>Clients</th>
                                                <th>Phone</th>
                                                <th>Company</th>
                                                <th>Added at</th>
                                                <th>Updated at</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($data as $info)
                                                <tr>
                                                    <td><image style="width:65px; height:60px;" src="{{url($info->image)}}"></td>
                                                    <td><span style="font-size:16px; color:black;">{{$info->name}} {{$info->surname}}</span></td>
                                                    <td><span style="font-size:16px; color:black;">{{$info->phone}}</span></td>
                                                    <td><span style="font-size:16px; color:black;">{{$info->company}}</span></td>
                                                    <td><span style="font-size:13px; color:black;" class="badge badge-success">{{$info->created_at}}</span></td>
                                                    <td><span style="font-size:13px; color:black;" class="badge badge-info">{{$info->updated_at}}</span></td>
                                                    <td><a href="{{route('cedit',$info->id)}}"><button type="submit" class="btn btn-sm btn-info"><i style="font-size:14px;" class="fas fa-edit"></i></button></a>
                                                    <a href="{{route('cdelete',$info->id)}}"><button type="submit" class="btn btn-sm btn-danger"><i style="font-size:14px;" class="fas fa-trash-alt" aria-hidden="true"></i></button></a></td>
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