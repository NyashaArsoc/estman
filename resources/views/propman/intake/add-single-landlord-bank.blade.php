@php
$title = 'Add Landlord Bank';
$description = 'Add landlord details...';
$id= Crypt::encrypt($landlord->id);
@endphp
@extends('layout.no-menu-layout')
@section('title', 'Edit Landlord')
@section('additional css')
<!-- Additional css Start-->
<link rel="stylesheet" href="{{ asset('css/select2/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/select2-bootstrap-theme/select2-bootstrap.min.css') }}">
<!-- Additional css End-->
@endsection
@section('content')
<!-- Content Start-->
<div class="container-fluid">
    <h4>{{ $title }}</h4>
    <ol class="breadcrumb no-bg mb-1">
        <li class="breadcrumb-item"><a href="{{route('dash.property')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('propma.landlist') }}">List</a></li>
        <li class="breadcrumb-item"><a href="{{ route('propma.editland',$id) }}">View/Edit</a></li>
        <li class="breadcrumb-item active">{{ $title }}</li>
    </ol>
    <div class="box box-block bg-white">
        <h5>{{ $title }}</h5>
        <p class="font-90 text-muted mb-1"> {{ $description }}</p>
        <span class="badge badge-pill bg-info">{{$landlord->description ?? '' }}</span>
        <hr />
        <form class="form-material material-primary" method="POST" id="defaultform"
            action="{{ route('propin.addlandnewbank', $id) }}">@csrf
            <div id="corporategroup">
                <div class="form-group row">
                    <label for="CompanyName" class="col-sm-2 form-control-label">Landlord Name</label>
                    <div class="col-sm-4">
                        {{ $landlord->lastname ?? ''}} {{ $landlord->firstname ?? ''}}
                        {{ $landlord->companyname ?? ''}}
                    </div>
                </div>
            </div>
            <br />
            <h5>bank details </h5>
            <div class="form-group row">
                <label for="FirstName" class="col-sm-2 form-control-label">Currency</label>
                <div class="col-sm-4">
                    <select class="js-example-basic-single w-100" name="currencycode"
                        id="currencycode">
                        <option value="">Select Currency </option>
                        @foreach($currency as $abc)
                        <option value="{{ $abc->code }}"> {{ $abc->code }} </option>
                        @endforeach
                    </select>
                    <small id="currencycodecheck" style="color: red;">required </small>
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-sm-2 form-control-label">Account Name</label>
                <div class="col-sm-4">
                    <input name="accountname" class="form-control" id="accountname"
                        type="text">
                    <small id="accountnamecheck" style="color: red;">required</small>
                </div>
                <label for="" class="col-sm-2 form-control-label">Bank Name</label>
                <div class="col-sm-4">
                    <input name="bankname" class="form-control" id="bankname"
                        type="text">
                    <small id="banknamecheck" style="color: red;">required</small>
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-sm-2 col-form-label">Branch</label>
                <div class="col-sm-4">
                    <input name="branch" class="form-control " id="notrequiredgeneraltextcaps"
                        type="text">
                    <small id="notrequiredgeneraltextcapscheck" style="color: red;"></small>
                </div>
                <label for="" class="col-sm-2 col-form-label">Account Number</label>
                <div class="col-sm-4">
                    <input name="accountnumber" class="form-control " id="numericrequired"
                        type="text">
                    <small id="numericrequiredcheck" style="color: red;">required</small>
                </div>
            </div>
            <div class="form-group row">
                @if (in_array(1,$arraycontrolids))
                <div class="offset-sm-2 col-sm-10">
                    <button type="submit" class="btn btn-primary" id="btn-edit-landlord-bank">submit</button>
                </div>
                @endif
            </div>
            @include('layout.arlet')
        </form>
    </div>
</div>
<!-- Content End-->

@endsection
@section('additional js')
<script src="{{ asset('js/validation/intakepropman.js') }}"></script>
<script src="{{ asset('css/select2/select2.min.js') }}"></script>
<script src="{{ asset('js/select2.js') }}"></script>
<!-- Additional JS End-->
@endsection