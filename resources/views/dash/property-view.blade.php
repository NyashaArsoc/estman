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
