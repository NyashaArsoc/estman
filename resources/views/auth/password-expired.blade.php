@php
    $id= $username;
@endphp
@section('title', 'password expired')
@extends('layout.login-layout')
@section('content')
    <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container-fluid">
            <div class="sign-form">
                <div class="row">
                    <div class="col-md-4 offset-md-4 px-3">
                        <div class="box b-a-0">
                            <div class="pt-4 pb-2"><h4>Password Expired</h4> 
                                <a class="btn btn-primary" title="go back" href="{{route('dash.main')}}"><i class="ti-back-left"></i></a>
                            </div>
                            <form class="form-material material-primary" id="defaultform" action="{{ route('login.expirenew',$id) }}" 
                            method="POST">@csrf
                                <div class="form-group">
                                        <input type="password" name="oldpassword" class="form-control" autocomplete="off"
                                        id="currentpassword" placeholder="old password" autofocus>
                                        <small id="currentpasswordcheck" style="color: red;">required</small>
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password" class="form-control" id="password"
                                    placeholder="new password" autocomplete="off">
                                        <small id="passwordcheck" style="color: red;">required</small>
                                </div>
                                <div class="form-group">
                                    <input type="password" name="confirmpassword" class="form-control" id="confirmpassword"
                                    placeholder="confirm password" autocomplete="off">
                                        <small id="confirmpasswordcheck" style="color: red;">required</small>
                                </div>
                                <div class="px-2 form-group mb-0">
                                    <button type="submit" class="btn btn-primary btn-block text-uppercase" 
                                    name="btn-submit" id="btn-submit-pass-expire">log in</button>
                                </div>
                                @include('layout.arlet')
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('additional js')
<script src="{{ asset('js/validation/login.js') }}"></script>
     <!-- Additional JS End-->
@endsection