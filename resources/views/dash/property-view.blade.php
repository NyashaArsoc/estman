@php
    $title = 'Dashboard';
@endphp
@extends('layout.propman-main-menu')
@section('title', 'Property Dashboard')

@section('content')
    <!-- Content Start-->
    <div class="container-fluid">
        <div class="row"> 
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <div class="box box-block tile tile-2 bg-secondary mb-2">
                    <div class="t-icon right"><i class="ti-money"></i></div>
                    <div class="t-content">
                        <h2 class="mb-1">{{$base->code}}</h2>
                        <h6 class="text-uppercase">Base Currency</h6>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <div class="box box-block bg-white tile tile-4 mb-2">
                    <div class="t-icon left bg-info"><i class="ti-calendar"></i></div>
                    <div class="t-content text-xs-right">
                        <h6 class="text-uppercase">System Date</h6>
                        <h2 class="mb-0">{{$sysdates}}</h2>
                    </div>
                </div>
            </div> 
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <div class="box box-block bg-white tile tile-4 mb-2">
                    <div class="t-icon left bg-warning"><i class="ti-receipt"></i></div>
                    <div class="t-content text-xs-right">
                        <h6 class="text-uppercase">Invoices</h6>
                        <h2 class="mb-0">{{$invoice}}</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="row"> 
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <div class="box box-block tile tile-2 bg-info mb-2">
                    <div class="t-icon right"><i class="ti-user"></i></div>
                    <div class="t-content">
                        <h2 class="mb-1">{{$activelandlord}}</h2>
                        <h6 class="text-uppercase">Active Landlords</h6>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <div class="box box-block tile tile-2 bg-primary mb-2">
                    <div class="t-icon right"><i class="ti-home"></i></div>
                    <div class="t-content">
                        <h2 class="mb-1">{{$activeproperty}}</h2>
                        <h6 class="text-uppercase">Active Properties</h6>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <div class="box box-block tile tile-2 bg-info mb-2">
                    <div class="t-icon right"><i class="ti-user"></i></div>
                    <div class="t-content">
                        <h2 class="mb-1">{{$activetenant}}</h2>
                        <h6 class="text-uppercase">Active Tenants</h6>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <div class="box box-block tile tile-2 bg-primary mb-2">
                    <div class="t-icon right"><i class="ti-file"></i></div>
                    <div class="t-content">
                        <h2 class="mb-1">{{$activelease}}</h2>
                        <h6 class="text-uppercase">Active Leases</h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="row row-md mb-2">
            <div class="col-md-7">
                <div class="box bg-white">
                    <div class="box-block clearfix">
                        <h5 class="float-xs-left">Top 5 Upcoming Lease Renewal</h5>
                        <div class="float-xs-right">
                            <button class="btn btn-link btn-sm text-muted" type="button">
                                <i class="ti-angle-down"></i></button>
                            </div>
                            <table class="table mb-md-0">
                                <thead>
                                    <tr>
                                        <td><b>No</b></td><td><b>Tenant</b></td>
                                        <td><b>Description</b></td><td><b>Expire</b></td>
                                    </tr>
                                </thead>
                                <tbody>@php $count=1;@endphp
                                    @foreach($lease as $abc)
                                    <tr>
                                        <td>{{$count ++}}</td>
                                        <td>{{$abc->tenantfullname }} {{$abc->tenantcompanyname }}</td>
                                        <td>{{$abc->propertydescription}}</td>
                                        <td>{{$abc->validto}}</td>
                                    </tr>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Content End-->
@endsection

@section('additional js')
    <!-- Additional JS Start-->
    <script src="{{ asset('js/validation/lease.js') }}"></script>
    <script src="{{ asset('css/select2/select2.min.js') }}"></script>
    <script src="{{ asset('js/select2.js') }}"></script>
    <script src="{{ asset('js/dropdown.js') }}"></script>
    <script src="{{ asset('js/add-table-details.js') }}"></script> 
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <!-- Additional JS End-->
@endsection
