@php
$title = 'Dashboard';
@endphp
@extends('layout.propman-main-menu')
@section('title', 'Property Dashboard')
@section('additional css')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

@endsection
<style>
    /* Required for stripes effect */
    .progress-bar-striped {
        background-image: linear-gradient(45deg,
                rgba(255, 255, 255, 0.15) 25%,
                transparent 25%,
                transparent 50%,
                rgba(255, 255, 255, 0.15) 50%,
                rgba(255, 255, 255, 0.15) 75%,
                transparent 75%,
                transparent);
        background-size: 1rem 1rem;
    }

    /* Rounded edges */
    .progress,
    .progress-bar {
        border-radius: 1rem;
    }

    /* Optional: consistent height */
    .progress {
        height: 20px;
    }

    /* Optional color classes (in case Bootstrap 4.0.0-alpha.5 lacks them) */
    .bg-success {
        background-color: #28a745 !important;
    }

    .bg-info {
        background-color: #17a2b8 !important;
    }

    .bg-warning {
        background-color: #ffc107 !important;
    }

    .bg-danger {
        background-color: #dc3545 !important;
    }
</style>
@section('content')
<!-- Content Start-->
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
            <div class="box box-block tile tile-2 bg-secondary mb-2">
                <div class="t-icon right"><i class="ti-money"></i></div>
                <div class="t-content">
                    <h2 class="mb-1">{{$base}}</h2>
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
    <!-- Monthly Collections -->
    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4 shadow-sm" style="border-radius: 1rem;">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Yearly Collections/Billables {{$base}}</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Chart Area -->
                        <div class="col-md-12">
                            <div id="sales-chart"></div>
                        </div>
                    </div>
                </div>

                <!-- Footer Stats -->
                <div class="card-footer">
                    <div class="row text-center">
                        <div class="col-md-3 col-6 border-end">
                            <h5 class="fw-bold mb-0">${{number_format($ytdpaid,2)}}</h5>
                            <small class="text-uppercase">YTD Rent Collected</small>
                        </div>
                        <div class="col-md-3 col-6 border-end">
                            <h5 class="fw-bold mb-0">${{number_format($ytdowing,2)}}</h5>
                            <small class="text-uppercase">YTD Rent Outstanding</small>
                        </div>
                        <div class="col-md-3 col-6 border-end mt-3 mt-md-0">
                            <h5 class="fw-bold mb-0">${{number_format($currentpaid,2)}}</h5>
                            <small class="text-uppercase">Current Rent Collected</small>
                        </div>
                        <div class="col-md-3 col-6 mt-3 mt-md-0">
                            <h5 class="fw-bold mb-0">${{number_format($currentowing,2)}}</h5>
                            <small class="text-uppercase">35day/less Rent Outstanding</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- end Monthly Collections -->
        <div class="col-md-6">
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
                                <td><b>No</b></td>
                                <td><b>Tenant</b></td>
                                <td><b>Description</b></td>
                                <td><b>Expire</b></td>
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
<script>
    fetch('/dashboard/property/chart') // replace with your actual API route
        .then(response => response.json())
        .then(data => {
            const sales_chart_options = {
                series: [{
                        name: 'Invoices',
                        data: data.invoices
                    },
                    {
                        name: 'Receipts',
                        data: data.receipts
                    }
                ],
                chart: {
                    height: 180,
                    type: 'area',
                    toolbar: {
                        show: false
                    }
                },
                legend: {
                    show: false
                },
                colors: ['#0d6efd', '#20c997'],
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth'
                },
                xaxis: {
                    type: 'datetime',
                    categories: data.dates
                },
                tooltip: {
                    x: {
                        format: 'MMMM yyyy'
                    }
                }
            };

            const sales_chart = new ApexCharts(
                document.querySelector('#sales-chart'),
                sales_chart_options
            );
            sales_chart.render();
        })
        .catch(error => {
            console.error('Error loading chart data:', error);
        });
</script>
@endsection