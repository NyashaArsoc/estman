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
                <div class="box box-block tile tile-2 bg-info mb-2">
                    <div class="t-icon right"><i class="ti-bag"></i></div>
                    <div class="t-content">
                        <h2 class="mb-1">{{count($portfolio)}}</h2>
                        <h6 class="text-uppercase">Pending Portfolios</h6>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <div class="box box-block bg-white tile tile-4 mb-2">
                    <div class="t-icon left bg-info"><i class="ti-receipt"></i></div>
                    <div class="t-content text-xs-right">
                        <h6 class="text-uppercase">All Pending Instructions</h6>
                        <h2 class="mb-0">{{$pending}}</h2>
                    </div>
                </div>
            </div> 
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <div class="box box-block tile tile-2 bg-success mb-2">
                    <div class="t-icon right"><i class="ti-email"></i></div>
                    <div class="t-content">
                        <h2 class="mb-1">{{$mail}}</h2>
                        <h6 class="text-uppercase">to mail</h6>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <div class="box box-block tile tile-2 bg-warning mb-2">
                    <div class="t-icon right"><i class="ti-check-box"></i></div>
                    <div class="t-content">
                        <h2 class="mb-1">{{count($portfolioreview)}}</h2>
                        <h6 class="text-uppercase">Portfolios Review</h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="row"> 
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <div class="box box-block tile tile-2 bg-info mb-2">
                    <div class="t-icon right"><i class="ti-printer"></i></div>
                    <div class="t-content">
                        <h2 class="mb-1">{{$print}}</h2>
                        <h6 class="text-uppercase">to Print</h6>
                    </div>
                </div>
            </div>	
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <div class="box box-block tile tile-2 bg-primary mb-2">
                    <div class="t-icon right"><i class="ti-ticket"></i></div>
                    <div class="t-content">
                        <h2 class="mb-1">{{$invoice}}</h2>
                        <h6 class="text-uppercase">to Invoice</h6>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <div class="box box-block tile tile-2 bg-warning mb-2">
                    <div class="t-icon right"><i class="ti-thumb-up"></i></div>
                    <div class="t-content">
                        <h2 class="mb-1">{{$approve}}</h2>
                        <h6 class="text-uppercase">to Approve</h6>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                <div class="box box-block tile tile-2 bg-secondary mb-2">
                    <div class="t-icon right"><i class="ti-thumb-up"></i></div>
                    <div class="t-content">
                        <h2 class="mb-1">{{$quality}}</h2>
                        <h6 class="text-uppercase">quality check</h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="row row-md mb-2">
            <div class="col-md-8">
                <div class="box bg-white">
                    <div class="box-block clearfix">
                        <h5 class="float-xs-left">top 10 completed this week</h5>
                        <div class="float-xs-right">
                            <button class="btn btn-link btn-sm text-muted" 
                            type="button"><i class="ti-angle-down"></i></button>
                        </div>
                    </div>
                    <table class="table mb-md-0">
                        <thead>
                            <tr>
                                <strong><td>No</td><td>Address</td><td>Operator</td><td>Date Completed</td></strong>
                            </tr>
                        </thead>
                        <tbody>
                            @php $count = 1; @endphp
                            @foreach($instructions as $abc)
                            <tr>
                              <th scope="row">{{ $count++ }}</th>
                              <td>{{ $abc->streetaddress }}</td>
                              <td>{{ $abc->completedby }}</td>
                              <td>{{ Carbon\Carbon::parse($abc->completedon)->format('F j, Y') ?? ''}} </td>
                            </tr>
                            @endforeach
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
