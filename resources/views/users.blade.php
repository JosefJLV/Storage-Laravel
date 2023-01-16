@extends('layouts.app')
@section('title')
Users
@endsection

@section('users')

@isset($sil_id)
    <div class="alert alert-danger">
        <b>Do u want to delete this user?</b><br><br>
        <a href="{{route('usil',$sil_id)}}"><button class="btn btn-sm btn-danger">Yes</button></a>
        <a href="{{route('users')}}"><button class="btn btn-sm btn-success">No</button></a>
    </div>
@endisset
@empty($editdata)
    <div class="alert alert-info">
        <form method="post" action="{{route('uadd')}}" enctype="multipart/form-data">
            @csrf
            <b>Full name:</b><br>
            <input type="text" name="name" class="form-control">
            <b>Email:</b><br>
            <input type="email" name="email" class="form-control">
            <b>Password:</b><br>
            <input type="password" name="pass" class="form-control">
            <b>Foto:</b><br>
            <input class="btn btn-sm" type="file" name="image"><br><br>
            <button type="submit" name="add" class="btn btn-success"><b>Add</b></button>
        </form>
    </div>

    <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="badge badge-outline-dark" style="font-size:16px;">Number of users: {{$say}}</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table student-data-table m-t-20 table-sm">
                                        <thead>
                                            <tr>
                                                <th>Foto</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Added at</th>
                                                <th>Updated at</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($data as $info)
                                                <tr>
                                                    <td><image style="width:65px; height:60px;" src="{{url($info->foto)}}"></td>
                                                    <td><span style="font-size:16px; color:black;">{{$info->name}}</span></td>
                                                    <td><span style="font-size:16px; color:black;">{{$info->email}}</span></td>
                                                    <td><span style="font-size:13px; color:black;" class="badge badge-success">{{$info->created_at}}</span></td>
                                                    <td><span style="font-size:13px; color:black;" class="badge badge-info">{{$info->updated_at}}</span></td>
                                                    @if($info->block =="0")
                                                        <td><a href="{{route('uedit',$info->id)}}"><button type="submit" class="btn btn-sm btn-info" title="Click to edit"><i style="font-size:14px;" class="fas fa-edit"></i></button></a>
                                                        <a href="{{route('udelete',$info->id)}}"><button type="submit" class="btn btn-sm btn-danger" title="Click to delete"><i style="font-size:14px;" class="fas fa-trash-alt" aria-hidden="true"></i></button></a>
                                                        <a href="{{route('block',$info->id)}}"><button type="submit" class="btn btn-sm btn-warning" title="Click to block"><i style="font-size:14px;" class="fas fa-user-lock" aria-hidden="true"></i></button></td>
                                                    @endif

                                                    @if($info->block == "1")
                                                        <td><a href="{{route('unblock',$info->id)}}"><button type="submit" class="btn btn-sm btn-success" title="Click to unblock"><i style="font-size:14px;" class="fas fa-times" aria-hidden="true"></i></button></td>
                                                    @endif
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
        <form method="post" action="{{route('uadd')}}" enctype="multipart/form-data">
            @csrf
            <b>Full name:</b><br>
            <input type="text" name="name" class="form-control" value="{{$editdata->name}}">
            <b>Email:</b><br>
            <input type="email" name="email" class="form-control" value="{{$editdata->email}}">
            <b>Password:</b><br>
            <input type="password" name="pass" class="form-control" value="{{$editdata->password}}"><br>
            <image style="width:65px; height:60px;" src="{{url($editdata->foto)}}"><br>            
            <input class="btn btn-sm" type="file" name="image"><br><br>
            <button type="submit" name="add" class="btn btn-info"><b>Update</b></button>
        </form>
    </div>
@endisset
@endsection 