@extends('layout.login-layout')
@section('title', 'login')
@section('content')
<div class="container-fluid">
        <div class="sign-form">
            <div class="row">
                <div class="col-md-4 offset-md-4 px-3">
                    <div class="box b-a-0">
                        <div class="p-2 text-xs-center">
                             <img src="{{ asset('img/ESTMANLOGIN.png') }}" alt="" title=""
                             width="217px" height="154px"> 
                            {{-- <img src="{{ asset('img/login logo.png') }}" alt="" title=""> --}}
                        </div>
                        <form class="form-material material-primary" id="defaultform" action="{{ route('login.login') }}" 
                        method="POST">@csrf
                            <div class="form-group">
                                <input type="text" class="form-control" id="username"
                                 name="username" autocomplete="off" placeholder="User Name" autofocus>
                                 <small id="usernamecheck" style="color: red;">username is required</small>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" id="password" 
                                name="password" autocomplete="off" placeholder="Password">
                                <small id="passwordcheck" style="color: red;">password is required</small>
                            </div>
                            <div class="px-2 form-group mb-0">
                                <button type="submit" class="btn btn-primary btn-block text-uppercase" 
                                name="btn-submit" id="btn-submit-login">Log in</button>
                            </div>
                            @include('layout.arlet')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('additional js')
<script src="{{ asset('js/validation/login.js') }}"></script>
     <!-- Additional JS End-->
@endsection