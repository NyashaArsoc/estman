@php
$title = 'Compile Instruction';
$description = 'instruction compilation details .';
$status = 'portfolio instruction';
 $badge = "badge badge-pill bg-success badge-secondary";
@endphp
@extends('layout.no-menu-layout')
@section('title', 'Compile')
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
        <li class="breadcrumb-item"><a href="{{ route('valapp.listallappro') }}">List</a></li>
        <li class="breadcrumb-item active">{{ $title }}</li>
    </ol>
    <div class="box box-block bg-white">
        <h5>{{ $title }}</h5>
        <p class="font-90 text-muted mb-1">{{ $description }}</p>
         <span class="{{ $badge }}">{{$status}}</span><hr/>
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
                action="{{ route('landlord.addlandlord') }}">@csrf
        <!-- Tabs Content -->
        <div class="tab-content" id="clientTabContent">
            <div class="tab-pane show active" id="instruction-info" role="tabpanel" aria-labelledby="instruction-info-tab">
                <table class="table table-bordered mt-3">
                    <tbody>
                        <tr>
                            <td><strong>Date Received:</strong></td>
                            <td>$client->firstname ?? </td>
                        </tr>
                        <tr>
                            <td><strong>Valuation Purpose:</strong></td>
                            <td>$client->middlename ?? </td>
                        </tr>
                        <tr>
                            <td><strong>Valuation Type:</strong></td>
                            <td>$client->lastname ?? </td>
                        </tr>
                        <tr>
                            <td><strong>Payment Agreement:</strong></td>
                            <td>$client->idnumber ?? </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane show" id="client-info" role="tabpanel" aria-labelledby="client-info-tab">
                <table class="table table-bordered mt-3">
                    <tbody>
                        <tr>
                            <td><strong>Name:</strong></td>
                            <td>$client->firstname ?? </td>
                        </tr>
                        <tr>
                            <td><strong>Contact Cell:</strong></td>
                            <td>$client->middlename ?? </td>
                        </tr>
                        <tr>
                            <td><strong>Tel:</strong></td>
                            <td>$client->lastname ?? </td>
                        </tr>
                        <tr>
                            <td><strong>Email:</strong></td>
                            <td>$client->idnumber ?? </td>
                        </tr>
                        <tr>
                            <td><strong>Contact Address:</strong></td>
                            <td>$client->gender ?? </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="property-info" role="tabpanel" aria-labelledby="property-info-tab">
                <table class="table table-bordered mt-3">
                    <tbody>
                        <tr>
                            <td><strong>Property Type:</strong></td>
                            <td>$client->firstname ?? </td>
                        </tr>
                        <tr>
                            <td><strong>Province:</strong></td>
                            <td>$client->middlename ?? </td>
                        </tr>
                        <tr>
                            <td><strong>Town:</strong></td>
                            <td>$client->lastname ?? </td>
                        </tr>
                        <tr>
                            <td><strong>Surbub:</strong></td>
                            <td>$client->idnumber ?? </td>
                        </tr>
                        <tr>
                            <td><strong>Stand Number:</strong></td>
                            <td>$client->gender ?? </td>
                        </tr>
                        <tr>
                            <td><strong>Street Address:</strong></td>
                            <td>$client->gender ?? </td>
                        </tr>
                        <tr>
                            <td><strong>Report document:</strong></td>
                            <td>$client->gender ?? </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div><br/>
        <div class="form-group row">
            <label for="" class="col-sm-2 form-control-label">Currency </label>
                <div class="col-sm-4">
                    <select class="js-example-basic-single w-100" name="currency" id="currency"/>
                    <option value="">select currency</option>
                    @foreach ($currency as $abc)
                    <option value="{{ $abc->code }}">{{ $abc->code }}</option>
                @endforeach
                    </select>
                    <small id="currencycodecheck" style="color: red;"> currency is required</small>
                </div>
            <label for="" class="col-sm-2 col-form-label">Invoiced Amount
            </label>
            <div class="col-sm-4">
                <input type="text" class="form-control" name="commentshighlights" 
                id="commentshighlights" />
            </div>
        </div>
        <div class="form-group row">
            <div class="form-group row">
                <div class="offset-sm-2 col-sm-10">
                    <button type="submit" class="btn btn-primary" id="btn-val-compile" >
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
<script src="{{ asset('js/validation/approval.js') }}"></script>
<script src="{{ asset('css/select2/select2.min.js') }}"></script>
<script src="{{ asset('js/select2.js') }}"></script>
    <!-- Additional JS End-->
@endsection