@extends('layout.main-welcome')
@section('title', 'Dashboard')
@section('content')
    <!-- Content End-->
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
            <a href="{{route('dash.property')}}" class="">
            <div class="box box-block tile tile-2 bg-primary mb-2">
                <div class="t-icon right"></div>
                <div class="t-content">
                    <h2 class="mb-1"><i class="ti-home"></i></h2>
                    <h6 class="text-uppercase">Property Management</h6>
                </div>
            </div>
            </a>
        </div> 
        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
        <a href="{{route('dash.property')}}" class="">
            <div class="box box-block tile tile-2 bg-primary mb-2">
                <div class="t-icon right"></div>
                <div class="t-content">
                    <h2 class="mb-1"><i class="ti-search"></i></h2>
                    <h6 class="text-uppercase">Valuation</h6>
                </div>
            </div>
        </a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
            <a href="{{route('login.profile')}}" class="">
            <div class="box box-block tile tile-2 bg-secondary mb-2">
                <div class="t-icon right"></div>
                <div class="t-content">
                    <h2 class="mb-1"><i class="ti-settings"></i></h2>
                    <h6 class="text-uppercase">Settings</h6>
                </div>
            </div>
            </a>
        </div>
    </div>
</div>
@endsection