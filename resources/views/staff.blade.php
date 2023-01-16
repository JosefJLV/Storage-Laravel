@extends('layouts.app')
@section('title')
Staff
@endsection

@section('staff')


@isset($sil_id)
    <div class="alert alert-danger">
        <b>Do u want to delete this staff member?</b><br><br>
        <a href="{{route('ssil',$sil_id)}}"><button class="btn btn-sm btn-danger">Yes</button></a>
        <a href="{{route('staff')}}"><button class="btn btn-sm btn-success">No</button></a>
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
    <div class="alert alert-info">
            <form method="post"  action="{{route('sadd')}}" enctype="multipart/form-data">
                @csrf
                <b>Full Name:</b>
                <input type="text" name="name" class="form-control" required>
                <b>Position:</b>
                <input type="text" name="position" class="form-control" required>
                <b>Phone:</b>
                <input type="number" name="phone" class="form-control" required>
                <b>Wage:</b>
                <input type="text" name="wage" class="form-control" required>
                <b>Birthday:</b>
                <input type="date" name="bdate" class="form-control"required>
                <b>Hired at:</b>
                <input type="date" name="hire" class="form-control" required>
                <b>Foto:</b><br>
                <input type="file" class="btn btn-sm" name="image"> <br><br> 
                <button type="submit" name="add" class="btn btn-success"><b>Add</b></button>
            </form>
    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="badge badge-outline-dark" style="font-size:16px;"><b>Number of staff: {{$say}}</b></h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table student-data-table m-t-20 table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Foto</th>
                                                    <th>Name</th>
                                                    <th>Position</th>
                                                    <th>Phone</th>
                                                    <th>Wage</th>
                                                    <th>Birthday</th>
                                                    <th>Hired at</th>
                                                    <th>Added at</th>
                                                    <th>Updated at</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($data as $info)
                                                <tr>
                                                    <td><image style="width:65px; height:60px;" src="{{url($info->foto)}}"></td>
                                                    <td><span style="font-size:16px; color:black;">{{$info->name}}</span></td>
                                                    <td><span style="font-size:16px; color:black;">{{$info->position}}</span></td>
                                                    <td><span style="font-size:16px; color:black;">{{$info->phone}}</span></td>
                                                    <td><span class="badge badge-outline-dark" style="font-size:14px; color:black;">{{$info->wage}} <i class='fas fa-euro-sign' style='font-size:14px'></i></span></td>
                                                    <td><span class="badge badge-danger">{{$info->birthdate}}</span></td>
                                                    <td><span class="badge badge-info">{{$info->hired_at}}</span></td>
                                                    <td><span class="badge badge-success">{{$info->created_at}}</span></td>
                                                    <td><span class="badge badge-secondary">{{$info->updated_at}}</span></td>
                                                    <td>
                                                        <a href="{{route('sdelete',$info->id)}}"><button type="submit" class="btn btn-sm btn-danger" title="Click to delete"><i class="fas fa-trash-alt" aria-hidden="true"></i></button></a>
                                                        <a href="{{route('sedit',$info->id)}}"><button type="submit" class="btn btn-sm btn-info" title="Click to edit"><i class="fas fa-edit"></i></button></a>
                                                        <a href="{{route('document',$info->id)}}"><button type="submit" class="btn btn-sm btn-warning"><i class="fas fa-file-alt"></i></button></a>
                                                    </td>
                                                    <td></td>
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
                    <form method="post"  action="{{route('supdate')}}" enctype="multipart/form-data">
                        @csrf
                        <b>Full Name:</b>
                        <input type="text" name="name" class="form-control" value="{{$editdata->name}}">
                        <b>Position:</b>
                        <input type="text" name="position" class="form-control" value="{{$editdata->position}}">
                        <b>Phone:</b>
                        <input type="number" name="phone" class="form-control" value="{{$editdata->phone}}">
                        <b>Wage:</b>
                        <input type="text" name="wage" class="form-control" value="{{$editdata->wage}}">
                        <b>Birthday:</b>
                        <input type="date" name="bdate" class="form-control" value="{{$editdata->birthdate}}">
                        <b>Hired at:</b>
                        <input type="date" name="hire" class="form-control" value="{{$editdata->hired_at}}"><br>
                        <image style="width:65px; height:60px;" src="{{url($editdata->foto)}}"><br>
                        <input type="file" class="btn btn-sm" name="image"> <br><br> 
                        <input type="hidden" name="id" value="{{$editdata->id}}">
                        <button type="submit" name="add" class="btn btn-info"><b>Update</b></button>
                    </form>
            </div>

        @endisset
@endsection