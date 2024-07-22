@extends('layout.login-layout')
@section('title', '500')
@section('content')
<div class="container-fluid">
        <div class="sign-form">
            <div class="row">
                <div class="col-md-4 offset-md-4 px-3">
                    <div class="box b-a-0">
                        <div class="p-2 text-xs-center">
                            <h3>INTERNAL SERVER ERROR</h3>
                            <a class="btn btn-warning btn-sm "  href="{{route('dash.val')}}"
                                title="back"><i class="ti-back-left mr-0-5"></i>back</a>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
