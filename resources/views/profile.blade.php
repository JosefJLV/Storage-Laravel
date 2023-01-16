@extends('layouts.app')
@section('profile')
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title"><b>My Profile</b></h4>
                            </div>
                            <div class="card-body">
                                <div class="form-validation">
                                    <form class="form-valide" action="{{route('submit')}}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-xl-6">
                                            @if(session('success'))
                                                <div class="text-center alert alert-info" style="font-size:16px">
                                                    <b>{{session('success')}}</b>
                                                </div>
                                            @endif
                                            @if(session('wrong'))
                                                <div class="text-center alert alert-danger" style="font-size:16px">
                                                    <b>{{session('wrong')}}</b>
                                                </div>
                                            @endif
                                                <div class="form-group row">
                                                    <label class="col-lg-4 col-form-label" for="val-username">Full name
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <div class="col-lg-6">
                                                        <input type="text" class="form-control" id="val-username" name="name" value="{{$data->name}}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-4 col-form-label" for="val-email">Email <span
                                                            class="text-danger">*</span>
                                                    </label>
                                                    <div class="col-lg-6">
                                                        <input type="text" class="form-control" id="val-email" name="email" value="{{$data->email}}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-4 col-form-label" for="val-password">Password
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <div class="col-lg-6">
                                                        <input type="password" class="form-control" id="val-password" name="password" placeholder="Your Password" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-4 col-form-label" for="val-password">New Password
                                                    </label>
                                                    <div class="col-lg-6">
                                                        <input type="password" class="form-control" id="val-password" name="npassword" placeholder="Skip if you don't want to change">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-4 col-form-label" for="val-confirm-password">Confirm Password 
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <div class="col-lg-6">
                                                        <input type="password" class="form-control" id="val-confirm-password" name="cpassword" placeholder="..and confirm your password!" required>
                                                    </div>
                                                </div>
                                                                                              
                                            </div>
                                        <div class="col-xl-6">
                                            <img src="{{$data->foto}}" class="img-fluid rounded-circle" style="width:250px; height:250px;" alt="">
                                            <input type="file" class="btn btn-sm" name="image">
                                        </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-8 ml-auto">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
@endsection