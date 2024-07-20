@php
    $title = 'Dashboard';
@endphp
@extends('layout.val-main-menu')
@section('title', 'Valuations Dashboard')

@section('content')
    <!-- Content Start-->
    <!-- Content Start-->
    <div class="container-fluid">
        <div class="row"> 
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <div class="box box-block tile tile-2 bg-secondary mb-2">
                    <div class="t-icon right"><i class="ti-money"></i></div>
                    <div class="t-content">
                        <h2 class="mb-1"></h2>
                        <h6 class="text-uppercase">Base Currency</h6>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <div class="box box-block bg-white tile tile-4 mb-2">
                    <div class="t-icon left bg-info"><i class="ti-calendar"></i></div>
                    <div class="t-content text-xs-right">
                        <h6 class="text-uppercase">System Date</h6>
                        <h2 class="mb-0"></h2>
                    </div>
                </div>
            </div> 
        </div>
        <div class="row"> 
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <div class="box box-block tile tile-2 bg-primary mb-2">
                    <div class="t-icon right"><i class="ti-bar-chart"></i></div>
                    <div class="t-content">
                        <h2 class="mb-1"></h2>
                        <h6 class="text-uppercase">Active Properties</h6>
                    </div>
                </div>
            </div>	
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <div class="box box-block tile tile-2 bg-primary mb-2">
                    <div class="t-icon right"><i class="ti-bar-chart"></i></div>
                    <div class="t-content">
                        <h2 class="mb-1"></h2>
                        <h6 class="text-uppercase">Active Tenants</h6>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <div class="box box-block tile tile-2 bg-primary mb-2">
                    <div class="t-icon right"><i class="ti-bar-chart"></i></div>
                    <div class="t-content">
                        <h2 class="mb-1"></h2>
                        <h6 class="text-uppercase">Active Leases</h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="row row-md mb-2">
            <div class="col-md-8">
                <div class="box bg-white">
                    <div class="box-block clearfix">
                        <h5 class="float-xs-left">Upcoming Lease Renewal</h5>
                        <div class="float-xs-right">
                            <button class="btn btn-link btn-sm text-muted" 
                            type="button"><i class="ti-angle-down"></i></button>
                        </div>
                    </div>
                    <table class="table mb-md-0">
                        <thead>
                            <tr>
                                <strong><td>No</td><td>Tenant</td><td>Description</td><td>Expire</td></strong>
                            </tr>
                        </thead>
                        <tbody>@php $count=1;@endphp
                            
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Content End-->
    <!-- Content End-->
@endsection
@section('additional js')
    <!-- Additional JS Start-->
    <!-- Additional JS End-->
@endsection
