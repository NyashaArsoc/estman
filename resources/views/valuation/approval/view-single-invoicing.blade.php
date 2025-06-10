@php
$title = 'Invoicing Instruction';
$description = 'instruction invoicing details .';
$status = trim($instr->isportfolio)=='N' ?
'<span class="badge badge-pill bg-primary">normal instruction</span>'
: '<span class="badge badge-pill bg-info">portfolio instruction</span>';
$id= Crypt::encrypt($currstage->id);
$instr_id= Crypt::encrypt($instr->id);
$attachementdoc = ($upload !== null && !is_null($upload->reportdoc)) ? 'download report' : '';
$reportdoc = ($upload !== null && !is_null($upload->reportdoc)) ? route('valapp.downdoc',[$instr_id]) : '';
@endphp
@extends('layout.no-menu-layout')
@section('title', 'Invoicing')
@section('additional css')
<link rel="stylesheet" type="text/css" href="{{ asset('css/select2/select2.min.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('css/select2-bootstrap-theme/select2-bootstrap.min.css') }}" />
@endsection
@section('content')
<!-- Content Start-->
<div class="container-fluid">
    <h4>{{ $title }}</h4>
    <ol class="breadcrumb no-bg mb-1">
        <li class="breadcrumb-item"><a href="{{ route('dash.val') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('valapp.listinvoices') }}">List</a></li>
        <li class="breadcrumb-item active">{{ $title }}</li>
    </ol>
    <div class="box box-block bg-white">
        <h5>{{ $title }}</h5>
        <p class="font-90 text-muted mb-1">{{ $description }}</p>
        {!! $status !!}
        <hr />
        <!-- Tabs Navigation -->
        <ul class="nav nav-tabs" id="clientTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="instruction-info-tab" data-toggle="tab" href="#instruction-info" role="tab" aria-controls="instruction-info" aria-selected="true">Instruction Information</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="client-info-tab" data-toggle="tab" href="#client-info" role="tab" aria-controls="client-info" aria-selected="true">Client Information</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="property-info-tab" data-toggle="tab" href="#property-info" role="tab" aria-controls="property-info" aria-selected="false">Property Details</a>
            </li>
        </ul>
        <form class="form-material material-primary" id="defaultform" method="POST"
            action="{{ route('valapp.sbtinvoic',$id) }}">@csrf
            <!-- Tabs Content -->
            <div class="tab-content" id="clientTabContent">
                <div class="tab-pane show active" id="instruction-info" role="tabpanel" aria-labelledby="instruction-info-tab">
                    <table class="table table-bordered mt-3">
                        <tbody>
                            <tr>
                                <td><strong>Instruction No:</strong></td>
                                <td>{{ $instr->id}} </td>
                            </tr>
                            <tr>
                                <td><strong>Date Received:</strong></td>
                                <td>{{ Carbon\Carbon::parse($purpose->datestamp)->format('F j, Y') ?? ''}} </td>
                            </tr>
                            <tr>
                                <td><strong>Valuation Purpose:</strong></td>
                                <td>{{$purpose->purpose ?? ''}} </td>
                            </tr>
                            <tr>
                                <td><strong>Valuation Type:</strong></td>
                                <td>{{$purpose->type ?? ''}} </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane show" id="client-info" role="tabpanel" aria-labelledby="client-info-tab">
                    <table class="table table-bordered mt-3">
                        <tbody>
                            <tr>
                                <td><strong>Name:</strong></td>
                                <td>{{$client->companyname ?? ''}} {{$client->lastname ?? ''}}
                                    {{$client->firstname ?? ''}}
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Contact Person:</strong></td>
                                <td>{{$client->contactfirstname ?? ''}} {{$client->contactlastname ?? ''}}</td>
                            </tr>
                            <tr>
                                <td><strong>Cell:</strong></td>
                                <td>{{$client->cell ?? ''}} </td>
                            </tr>
                            <tr>
                                <td><strong>Email:</strong></td>
                                <td>{{$client->email ?? ''}}</td>
                            </tr>
                            <tr>
                                <td><strong>Contact Address:</strong></td>
                                <td>{{$client->contactddress ?? ''}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="property-info" role="tabpanel" aria-labelledby="property-info-tab">
                    <table class="table table-bordered mt-3">
                        <tbody>
                            <tr>
                                <td><strong>Property Type:</strong></td>
                                <td>{{$properties->propertytype ?? ''}} </td>
                            </tr>
                            <tr>
                                <td><strong>Province:</strong></td>
                                <td>{{$properties->province ?? ''}} </td>
                            </tr>
                            <tr>
                                <td><strong>Town:</strong></td>
                                <td>{{$properties->town ?? ''}} </td>
                            </tr>
                            <tr>
                                <td><strong>Surbub:</strong></td>
                                <td>{{$properties->suburb ?? ''}} </td>
                            </tr>
                            <tr>
                                <td><strong>Stand Number:</strong></td>
                                <td>{{$properties->standnumber ?? ''}} </td>
                            </tr>
                            <tr>
                                <td><strong>Street Address:</strong></td>
                                <td>{{$properties->streetaddress ?? ''}} </td>
                            </tr>
                            <tr>
                                <td><strong>Report document:</strong></td>
                                <td><a href="{{ $reportdoc }}">{{ $attachementdoc}}</a> </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div><br />
            <div class="form-group row">
                <label for="" class="col-sm-2 form-control-label">Currency </label>
                <div class="col-sm-4">
                    <select class="js-example-basic-single w-100" name="currencycode" id="currencycode" />
                    <option value="">select currency</option>
                    @foreach ($currency as $abc)
                    <option value="{{ $abc->code }}">{{ $abc->code }}</option>
                    @endforeach
                    </select>
                    <small id="currencycodecheck" style="color: red;">required</small>
                </div>
                <label for="" class="col-sm-2 col-form-label">Invoiced Amount
                </label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="invoicedamount"
                        id="marketvalue" />
                    <small id="marketvaluecheck" style="color: red;">required</small>
                </div>
            </div>
            <div class="form-group row">
                <div class="form-group row">
                    <div class="offset-sm-2 col-sm-10">
                        <button type="submit" class="btn btn-primary" id="btn-val-invoicing">
                            submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Content End -->
@endsection
@section('additional js')
<script src="{{ asset('js/validation/approvalvaluation.js') }}"></script>
<script src="{{ asset('css/select2/select2.min.js') }}"></script>
<script src="{{ asset('js/select2.js') }}"></script>
<!-- Additional JS End-->
@endsection