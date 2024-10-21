@php
$title = 'View Lease';
$description = 'below are lease details .';
$id= Crypt::encrypt($lease->id);
$agreement= Crypt::encrypt($lease->agreement);
if ($lease->propertytypeid != 1){
  $div =  ' <tr> <td><strong>Space Taken:</strong></td>
         <td>'.$lease->areataken .'</td> </tr><tr> <td><strong>Rate/spm:</strong></td>
         <td>'.$lease->ratesqm .'</td> </tr>';
 }else{
    $div = '';
 }
 $attachementrequiredpdf = (!is_null($lease->agreement)) ? 'download file' : '';
$requiredpdf    = (!is_null($lease->agreement)) ? route('propapp.dwnagrepdf',[$agreement]) : '';
@endphp
@extends('layout.no-menu-layout')
@section('title', 'View')
@section('additional css')
@endsection
@section('content')
<!-- Content Start-->
<div class="container-fluid">
    <h4>{{ $title }}</h4>
    <ol class="breadcrumb no-bg mb-1">
        <li class="breadcrumb-item"><a href="{{ route('dash.property') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('propma.lealist') }}">List</a></li>
        <li class="breadcrumb-item active">{{ $title }}</li>
    </ol>
    <div class="box box-block bg-white">
        <h5>{{ $title }}</h5>
        <p class="font-90 text-muted mb-1">{{ $description }}</p>
        <span class="badge badge-pill bg-info">{{$lease->propertytype ?? '' }}</span><hr/>
        <!-- Tabs Navigation -->
        <ul class="nav nav-tabs" id="clientTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="property-detail-tab" data-toggle="tab" href="#property-detail" role="tab" aria-controls="property-detail" aria-selected="true">Lease Details</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="rates-detail-tab" data-toggle="tab" href="#rates-detail" role="tab" aria-controls="rates-detail" aria-selected="true">Lease Rates</a>
            </li>
        </ul>
        <!-- Tabs Content -->
        <div class="tab-content" id="clientTabContent">
            <div class="tab-pane show active" id="property-detail" role="tabpanel" aria-labelledby="property-detail-tab">
                <table class="table table-bordered mt-3">
                    <tbody>
                        <tr>
                            <td><strong>Landlord:</strong></td>
                            <td>{{ $lease->landlordcontact ?? ''}} </td>
                        </tr>
                        <tr>
                            <td><strong>Tenant:</strong></td>
                            <td>{{ $lease->tenantfullname ?? ''}} {{ $lease->tenantcompanyname ?? ''}}</td>
                        </tr>
                        <tr>
                            <td><strong>Property Address:</strong></td>
                            <td> {{ $lease->streetaddress ?? ''}} </td>
                        </tr>
                        <tr>
                            <td><strong>Property Description:</strong></td>
                            <td> {{ $lease->propertydescription ?? ''}} </td>
                        </tr>
                        <tr>
                            <td><strong>Valid From:</strong></td>
                            <td> {{ $lease->validfrom ?? ''}}</td>
                        </tr>
                        <tr>
                            <td><strong>Valid To:</strong></td>
                            <td>{{ $lease->validto ?? ''}}</td>
                        </tr>
                        <tr>
                            <td><strong>Inspection:</strong></td>
                            <td>{{ $lease->inspectionreview ?? ''}}</td>
                        </tr>
                        <tr>
                            <td><strong>Rent Review:</strong></td>
                            <td>{{ $lease->rentreview ?? ''}} </td>
                        </tr>
                        <tr>
                            <td><strong>Rental:</strong></td>
                            <td>{{ $lease->currencycode ?? ''}}{{ number_format($lease->rental,2) ?? ''}} </td>
                        </tr>
                        {!! $div !!} 
                        <tr>
                            <td><strong>Agreement:</strong></td>
                            <td><a href="{{ $requiredpdf }}">{{ $attachementrequiredpdf}}</a> </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane show" id="rates-detail" role="tabpanel" aria-labelledby="rates-detail-tab">
                <h5 class="mt-2">Lease Rates</h5><hr/>
                <table  class="datatable table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>No</th> <th>Deposit</th> <th>levies</th><th>Operation</th><th>Currency</th>
                        </tr>
                    </thead>
                    <tbody>@php $count=1;@endphp
                        @foreach($rates as $abc)
                        <tr>
                            <td>{{$count ++}}</td><td>{{ number_format($abc->deposit,2) }} </td>
                            <td>{{ number_format($abc->ratescosts,2) ?? ''}}</td>
                            <td>{{ number_format($abc->operationalcosts,2) }}</td><td>{{ $abc->currencycode }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div><br/>
        @include('layout.arlet')
    </div>
</div>
<!-- Content End -->
@endsection
@section('additional js')
<script src="{{ asset('js/validation/approvalpropman.js') }}"></script>
<script src="{{ asset('js/popupforms/manage-buttons.js') }}"></script> 
<script src="{{ asset('js/dropdown.js') }}"></script>
    <!-- Additional JS End-->
@endsection
