@php 
$title = 'My Profile';
$description = 'change password...'; @endphp
@extends('layout.main-layout')
@section('title', 'Profile')

@section('content')
    <!-- Content Start-->
    <div class="container-fluid">
        <h4>{{ $title }}</h4>
        <ol class="breadcrumb no-bg mb-1">
            <li class="breadcrumb-item"><a href="{{route('dash.property')}}">Dashboard</a></li>
            <li class="breadcrumb-item active">{{ $title }}</li>
        </ol>
        <div class="box box-block bg-white">
            <h5>{{ $title }}</h5>
            <p class="font-90 text-muted mb-1"> {{ $description }}</p>
            <form class="form-material material-primary" id="defaultform" method="POST"
                action="{{ route('login.editprofile') }}">@csrf
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">First Name</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control "
                       value="{{ $user->firstname ?? ''}}" readonly >
                    </div>
                    <label for="" class="col-sm-2 col-form-label">Last Name</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control " readonly
                        value="{{ $user->lastname ?? ''}}" />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Username</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" readonly
                       value="{{ $user->username ?? ''}}" >
                    </div>
                    <label for="" class="col-sm-2 col-form-label">Role</label>
                    <div class="col-sm-4">
                        <input type="email" class="form-control" readonly
                        value="{{ $role->description ?? ''}}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Cell</label>
                    <div class="col-sm-4">
                        <input type="tel" class="form-control" value="{{ $user->cell ?? ''}}" readonly>
                    </div>
                    <label for="" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-4">
                        <input type="tel" class="form-control" value="{{ $user->email ?? ''}}" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-4">
                        <input type="password" class="form-control" id="password"
                         name="Password" placeholder="Password" autocomplete="off" >
                         <small id="passwordcheck" style="color: red;"> password is required</small>
                    </div>
                    <label for="" class="col-sm-2 col-form-label">Confirm Password</label>
                    <div class="col-sm-4">
                        <input type="password" class="form-control" id="ConfirmPassword"
                         name="ConfirmPassword" placeholder="Password" autocomplete="off" >
                         <small id="confirmpasswordcheck" style="color: red;"> confirm password is required</small>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="offset-sm-2 col-sm-10">
                        <button type="submit" class="btn btn-primary" id="btn-user-profile" >
                            Submit</button>
                    </div>
                </div>
                @include('layout.arlet')
            </form>
        </div>
    </div>
    <!-- Content End-->
@endsection
@section('additional js')
<script src="{{ asset('js/validation/login.js') }}"></script>
     <!-- Additional JS End-->
@endsection
