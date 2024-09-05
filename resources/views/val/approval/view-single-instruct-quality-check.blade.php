@php
$title = 'Instruction Quality Check';
$description = 'report quality check .';
$status = trim($instr->isportfolio)=='N' ? 
'<span class="badge badge-pill bg-primary">normal instruction</span>'
    : '<span class="badge badge-pill bg-info">portfolio instruction</span>';
$id= Crypt::encrypt($currstage->id);
$instr_id= Crypt::encrypt($instr->id);
$attachementdoc = ($upload !== null && !is_null($upload->reportdoc)) ? 'download report' : '';
$attachementexcel = ($upload !== null && !is_null($upload->reportexcel)) ? 'download schedule' : '';
$reportdoc = ($upload !== null && !is_null($upload->reportdoc)) ? route('valapp.dwndoc',[$instr_id]) : '';
$reportexc = ($upload !== null && !is_null($upload->reportexcel)) ? route('valapp.dwnexc',[$instr_id]) : '';
@endphp
@extends('layout.no-menu-layout')
@section('title', 'Quality Check')
@section('additional css')
<link rel="stylesheet" type="text/css" href="{{ asset ('css/display.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('css/select2/select2.min.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('css/select2-bootstrap-theme/select2-bootstrap.min.css') }}" />
@endsection
@section('content')
<!-- Content Start-->
<div class="container-fluid">
    <h4>{{ $title }}</h4>
    <ol class="breadcrumb no-bg mb-1">
        <li class="breadcrumb-item"><a href="{{ route('dash.val') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('valapp.listquality') }}">List</a></li>
        <li class="breadcrumb-item active">{{ $title }}</li>
    </ol>
    <div class="box box-block bg-white">
        <h5>{{ $title }}</h5>
        <p class="font-90 text-muted mb-1">{{ $description }}</p>
        {!! $status !!}<hr/>
        <!-- Tabs Navigation -->
        <ul class="nav nav-tabs" id="clientTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link" id="instruction-info-tab" data-toggle="tab" href="#instruction-info" role="tab" aria-controls="instruction-info" aria-selected="true">Instruction Information</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="client-info-tab" data-toggle="tab" href="#client-info" role="tab" aria-controls="client-info" aria-selected="true">Client Information</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" id="property-info-tab" data-toggle="tab" href="#property-info" role="tab" aria-controls="property-info" aria-selected="false">Property Details</a>
            </li>
        </ul>
        <form class="form-material material-primary" id="defaultform" method="POST" enctype="multipart/form-data"
                action="{{ route('valapp.sbtqty',[$id,$instr_id]) }}">@csrf
        <!-- Tabs Content -->
        <div class="tab-content" id="clientTabContent">
            <div class="tab-pane fade" id="instruction-info" role="tabpanel" aria-labelledby="instruction-info-tab">
                <table class="table table-bordered mt-3">
                    <tbody>
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
                                {{$client->firstname ?? ''}}</td>
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
            <div class="tab-pane show active" id="property-info" role="tabpanel" aria-labelledby="property-info-tab">
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
                        <tr>
                            <td><strong>Report Schedule:</strong></td>
                            <td><a href="{{ $reportexc }}">{{ $attachementexcel}}</a> </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div><h5>Property Values</h5>
        <div class="table-responsive">
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>Market Value</th>
                        <th>Rental Value</th>
                        <th>Forced Sale</th>
                        <th>Fair Value</th>
                        <th>Land Value</th>
                        <th>DRC</th>
                        <th>GRC</th>
                        <th>DPN</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{$prevstage->marketvalue ?? ''}}</td>
                        <td>{{$prevstage->rentalvalue ?? ''}}</td>
                        <td>{{$prevstage->forcedsale ?? ''}}</td>
                        <td>{{$prevstage->fairvalue ?? ''}} </td>
                        <td>{{$prevstage->landvalue ?? ''}} </td>
                        <td>{{$prevstage->drc ?? ''}} </td>
                        <td>{{$prevstage->grc ?? ''}} </td>
                        <td>{{$prevstage->depreciation ?? ''}} </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <h5>Property Attachements</h5>
        <div class="form-group row">
            <label for="Cell" class="col-sm-2 col-form-label">Report
            </label>
            <div class="col-sm-4">
                <input type="file" class="form-control" id="reportdocument" name="reportdocument"
                accept=".doc">
                <input type="text" class="form-control" name="propertyaddress" 
                value="{{$properties->streetaddress ?? ''}}" hidden/>
                 <small id="reportdocumentcheck" style="color: red;">required</small>
            </div>
            <label for="" class="col-sm-2 col-form-label">Last Comment
            </label>
            <div class="col-sm-4">
                <small id="" style="color: rgb(15, 185, 125);">{{$prevstage->comments ?? ''}}</small>
            </div>
        </div>
        <div class="form-group row">
            
        </div>
        <div class="form-group row">
            <label for="" class="col-sm-2 col-form-label">Comments/Highlights
            </label>
            <div class="col-sm-4">
                <input type="text" class="form-control" name="commentshighlights" 
                id="commentshighlights" />
            </div>
            <label for="email" class="col-sm-2 text-uppercase">
                <small>Print Report?</small></label>
            <div class="col-sm-4">
                <label class="switchToggle">
                    <input type="checkbox" name="isprintreport"
                    id="isprintreport" checked />
                    <span class="sliderswitchToggle round"></span> </label>
            </div>
        </div>
      <br/>
        <div class="form-group row">
            <div class="offset-sm-2 col-sm-10">
                <button type="submit" class="btn btn-primary" id="btn-val-quality" >
                    submit</button>
            </div>
        </div>
        </form>
    </div>
</div>
<!-- Content End -->
@endsection
@section('additional js')
<script src="{{ asset('js/validation/approval.js') }}"></script>
    <!-- Additional JS End-->
@endsection