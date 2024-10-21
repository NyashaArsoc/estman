@php
$title = 'View Lease';
$description = 'below are lease details .';
$id= Crypt::encrypt($lease->id);
$agreement= Crypt::encrypt($lease->agreement);
 $divindividualclass = $lease->propertytypeid == 1 ? 'hide': 'dropdwn';
$divcompanyclass = $lease->propertytypeid != 1 ? 'hide': 'dropdwn';
 $attachementrequiredpdf = (!is_null($lease->agreement)) ? 'download file' : '';
$requiredpdf    = (!is_null($lease->agreement)) ? route('propapp.dwnagrepdf',[$agreement]) : '';
@endphp
@extends('layout.no-menu-layout')
@section('title', 'View')
@section('additional css')
<link rel="stylesheet" href="{{ asset('css/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2-bootstrap-theme/select2-bootstrap.min.css') }}">
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
        <form class="form-material material-primary" id="defaultform" method="POST"
                action="{{ route('propma.updtlea', $id)}}">@csrf
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
                            <td><strong>Rental:</strong></td>
                            <td> {{ number_format($lease->rental,2) ?? ''}}</td>
                        </tr>
                        <tr>
                            <td><strong>Agreement:</strong></td>
                            <td><a href="{{ $requiredpdf }}">{{ $attachementrequiredpdf}}</a> </td>
                        </tr>
                    </tbody>
                </table>
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label">Property Description</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="billingaddress"
                        name="propertydescription" value="{{ $lease->propertydescription ?? ''}}">
                           <small id="billingaddresscheck" style="color: red;">required</small> 
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-2 form-control-label">Valid From</label>
                    <div class="col-sm-4">
                        <input type="text"  name="propertytype" value="{{ $lease->propertytypeid ?? ''}}" hidden>
                        <input type="date" class="form-control" id="datefrom" name="leasevalidfrom"
                        value="{{ $lease->validfrom ?? ''}}">
                        <small id="datefromcheck" style="color: red;">required</small>
                    </div>
                    <label for="ClientType" class="col-sm-2 form-control-label">Valid To</label>
                    <div class="col-sm-4">
                        <input type="date" class="form-control" id="dateto" name="leasevalidto"
                        value="{{ $lease->validto ?? ''}}">
                        <small id="datetocheck" style="color: red;">required</small>
                    </div>
                </div>
                <h5>rental information (VAT incl)</h5>
        <div class="form-group row">
            <label for="City" class="col-sm-2 col-form-label">Rent Review Period</label>
            <div class="col-sm-4">
                <select class="js-example-basic-single w-100" name="rentreviewperiod"
                    id="rentreviewperiod" />
                    <option value="{{ $lease->rentreview ?? ''}}">{{ $lease->rentreview ?? ''}}</option>
                    <option value="monthly"> monthly </option>
                    <option value="quarterly"> quarterly </option>
                    <option value="halfyearly"> half yearly </option>
                    <option value="yearly"> yearly </option>
                </select>
                <small id="rentreviewcheck" style="color: red;">required</small>
            </div>
            <label for="Type" class="col-sm-2 form-control-label">Inspection Period</label>
                    <div class="col-sm-4">
                        <select class="js-example-basic-single w-100" name="inspectionperiod" id="periodlist"/>
                        <option value="{{ $lease->inspectionreview ?? ''}}">{{ $lease->inspectionreview ?? ''}}</option>
                        <option value="monthly"> monthly </option>
                        <option value="quarterly"> quarterly </option>
                        <option value="halfyearly"> half yearly </option>
                        <option value="yearly"> yearly </option>
                        </select>
                        <small id="periodlistcheck" style="color: red;"> required </small>
            </div>
        </div>
        <div class="form-group row">
            <label for="" class="col-sm-2 col-form-label">Currency</label>
            <div class="col-sm-4">
                <select class="js-example-basic-single w-100" name="currencycode" id="currencycode" />
                <option value="{{ $lease->currencycode ?? ''}}">{{ $lease->currencycode ?? ''}}</option>
                @foreach ($currency as $abc)
                    <option value="{{ $abc->code }}"> {{ $abc->code }}
                    </option>
                @endforeach
                </select>
                <small id="currencycodecheck" style="color: red;">required</small>
            </div>
        </div>
        <div class="form-group row">
            <div id="commercial" class="{{$divcompanyclass}}">
                <label for="" class="col-sm-2 col-form-label">Rate/sqm</label>
                <div class="col-sm-2">
                    <input type="text" class="form-control" id="expectedrate" name="expectedrate"
                    value="{{ $lease->ratesqm ?? ''}}">
                <small id="expectedratecheck" style="color: red;">required</small>
                </div>
                <label for="AreaTaken" class="col-sm-2 col-form-label">Area Taken(Sqm)</label>
                <div class="col-sm-2">
                    <input type="text" class="form-control" id="lettablearea" name="areataken"
                    value="{{ $lease->areataken ?? ''}}">
                    <small id="lettableareacheck" style="color: red;">required</small>
                </div>
                <label for="" class="col-sm-2 col-form-label">Calulated Rental</label>
                <div class="col-sm-2">
                    <strong id="rentalcalculatedcheck" style="color: rgb(37, 27, 182);"></strong>
                </div>
            </div>
            <div id="residential" class="{{$divindividualclass}}">
                <label for="" class="col-sm-2 col-form-label">Expected Rental</label>
                <div class="col-sm-2">
                    <input type="text" class="form-control" id="expectedrental" name="expectedrental"
                    value="{{ number_format($lease->rental,2) ?? ''}}">
                <small id="expectedrentalcheck" style="color: red;">required</small>
                </div>
            </div>
        </div>
        <div class="form-group row">
            @if (in_array(2,$arraycontrolids))
            <div class="offset-sm-2 col-sm-10">
                <button type="submit" class="btn btn-primary" id="btn-edit-lease" >submit</button>
            </div>
            @endif
        </div>
        </div>
            <div class="tab-pane show" id="rates-detail" role="tabpanel" aria-labelledby="rates-detail-tab">
                <h5 class="mt-2">Lease Rates</h5>
                @if (in_array(1,$arraycontrolids))
                <a  class="btn btn-primary btn-sm" href="{{route('propin.addlearate', $id)}}
                " title="add">create new</a>
                @endif<hr/>
                <table  class="datatable table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>No</th><th>levies</th><th>Operation</th><th>Currency</th><th>Option</th>
                        </tr>
                    </thead>
                    <tbody>@php $count=1;@endphp
                        @foreach($rates as $abc)
                        <tr>@php $rid= Crypt::encrypt($abc->id);@endphp
                            <td>{{$count ++}}</td>
                            <td>{{ number_format($abc->ratescosts,2) ?? ''}}</td>
                            <td>{{ number_format($abc->operationalcosts,2) }}</td><td>{{ $abc->currencycode }}</td>
                           <td> @if (in_array(2,$arraycontrolids))<a class="btn btn-secondary btn-sm"  
                                    href="{{route('propma.editlearat',[$rid,$id])}}"
                                    title="edit"><i class="ti-pencil mr-0-5"></i>edit</a>@endif</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div><br/>
        @include('layout.arlet')
        </form>
    </div>
</div>
<!-- Content End -->
@endsection
@section('additional js')
<script src="{{ asset('js/validation/intakepropman.js') }}"></script>
<script src="{{ asset('css/select2/select2.min.js') }}"></script>
    <script src="{{ asset('js/select2.js') }}"></script>
<script src="{{ asset('js/dropdown.js') }}"></script>
    <!-- Additional JS End-->
@endsection
