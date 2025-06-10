@php
$title = 'Declined Instruction';
$description = 'below are instruction details .';
$status = trim($instr->isportfolio)=='N' ?
'<span class="badge badge-pill bg-primary">normal instruction</span>'
: '<span class="badge badge-pill bg-info">portfolio instruction</span>';
$accessdate = trim($instr->isportfolio)=='Y' ? now() : $purpose->datedueaccessdate;
$id= Crypt::encrypt($acknow->id);
$instr_id= Crypt::encrypt($instr->id);
@endphp
@extends('layout.no-menu-layout')
@section('title', 'Declined')
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
        <li class="breadcrumb-item"><a href="{{ route('valdec.listackn') }}">List</a></li>
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
            action="{{ route('valdec.alloinstr',[$id,$instr_id]) }}">@csrf
            <!-- Tabs Content -->
            <div class="tab-content" id="clientTabContent">
                <div class="tab-pane show active" id="instruction-info" role="tabpanel" aria-labelledby="instruction-info-tab">
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
                            <tr>
                                <td><strong>Access Date:</strong></td>
                                <td>{{ Carbon\Carbon::parse($accessdate)->format('F j, Y H:m') ?? ''}} </td>
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
                                <td>{{$client->email ?? ''}} </td>
                            </tr>
                            <tr>
                                <td><strong>Contact Address:</strong></td>
                                <td>{{$client->contactaddress ?? ''}}</td>
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
                                <td><strong>Street Address:</strong></td>
                                <td>{{$properties->streetaddress ?? ''}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div><br />
            <div class="form-group row">
                <label for="" class="col-sm-2 col-form-label">Previous Comments
                </label>
                <div class="col-sm-4">
                    <div class="col-sm-4">
                        <small id="" style="color: rgb(15, 185, 125);">{{$acknow->comments ?? ''}}</small>
                    </div>
                </div>
                <label for="" class="col-sm-2 col-form-label">Valuer Name </label>
                <div class="col-sm-4">
                    <select class="js-example-basic-single w-100" name="valuername" id="valuername" />
                    <option value="{{$acknow->allocatedto }}">{{$acknow->completedby ?? ''}} </option>
                    @foreach ($valuer as $abc)
                    <option value="{{ $abc->userid }}"> {{ $abc->fullname }}
                    </option>
                    @endforeach
                    </select>
                    <small id="valuernamecheck" style="color: red;">required</small>
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-sm-2 form-control-label">Access Date</label>
                <div class="col-sm-4">
                    <input type="datetime-local" class="form-control"
                        id="portfolioduedate" name="accessdatetime">
                    <small id="portfolioduedatecheck" style="color: red;">required</small>
                </div>
            </div>

            <div class="form-group row">
                <div class="offset-sm-2 col-sm-4">
                    <button type="submit" class="btn btn-success btn-sm" id="btn-reallocate-entry"><i class="ti-reload mr-0-5">
                        </i>reallocate</button>
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