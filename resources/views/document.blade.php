@extends('layouts.app')

@section('title')
Documents
@endsection
@section('document')

    @isset($sil_id)
        <div class="alert alert-danger">
            <b>Do u want to delete this document?</b><br><br>
            <a href="{{route('doc-del',$sil_id)}}"><button class="btn btn-sm btn-danger">Yes</button></a>
            <a href="{{route('doc-list')}}"><button class="btn btn-sm btn-success">No</button></a>
        </div>
    @endisset 

@empty($editdata)

    
    <div class="alert alert-info">
            <form method="post"  action="{{route('docadd')}}" enctype="multipart/form-data">
                @csrf
                <b>Staff member</b>
                <input type="text" class="form-control" name="staff_id" value="{{$staff->name}}">
                <b>Title:</b>
                <input type="text" class="form-control" name="title">
                <b>Document</b><br>
                <input type="file" name="document" class="btn btn-sm"><br>
                <b>Note:</b><br>
                <textarea  name="note" rows="2" cols="140"></textarea><br>  
                <input type="hidden" name="id" value="{{$staff->id}}">
                <button type="submit" name="add" class="btn btn-success"><b>Add</b></button>
            </form> 
    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="badge badge-outline-dark" style="font-size:16px;"><b>Number of Documents-{{$docsay}}</b></h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table student-data-table m-t-20 table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Title:</th>
                                                    <th>Document:</th>
                                                    <th>Note:</th>
                                                    <th>Added at:</th>
                                                    <th>Updated at:</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($data as $info)
                                                <tr>
                                                    <td>{{$info->title}}</td>
                                                    <td><image id="myImg" style="width:65px; height:60px;" src="{{url($info->document)}}"></td>
                                                    <td><span style="font-size:16px; color:black;">{{$info->note}}</span></td>
                                                    <td><span class="badge badge-success">{{$info->created_at}}</span></td>
                                                    <td><span class="badge badge-secondary">{{$info->updated_at}}</span></td>
                                                    <td>
                                                        <a href="{{route('doc-del',$info->id)}}"><button type="submit" class="btn btn-sm btn-danger" title="Click to delete"><i class="fas fa-trash-alt" aria-hidden="true"></i></button></a>
                                                        <a href="{{route('doc-edit',$info->id)}}"><button type="submit" class="btn btn-sm btn-info" title="Click to edit"><i class="fas fa-edit"></i></button></a>
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
        <div class="alert alert-info">
            <form method="post"  action="{{route('doc-update')}}" enctype="multipart/form-data">
                @csrf
                <b>Title:</b>
                <input type="text" class="form-control" name="title" value="{{$editdata->title}}">
                <b>Document</b><br>
                <image style="width:85px; height:85px;" src="{{url($editdata->document)}}"><br>
                <input type="file" name="document" class="btn btn-sm"><br> 
                <b>Note:</b><br>
                <input type="text" class="form-control" name="note" value="{{$editdata->note}}"><br>  
                <input type="hidden" name="id" value="{{$editdata->id}}">
                <button type="submit" name="update" class="btn btn-primary"><b>Update</b></button>
            </form> 
        </div>

@endisset

@endsection