@php
$title = 'Leave Group Definition';
$description = 'define the days to accrue per month and limits...';
$groupid= Crypt::encrypt($typegroup->groupid); @endphp
@extends('layout.no-menu-layout')
@section('title', 'Group Definition')
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
        <li class="breadcrumb-item"><a href="{{route('dash.setup')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('setman.listlevgrp') }}">List</a></li>
        <li class="breadcrumb-item"><a href="{{ route('setman.typperlevgrp',$groupid) }}">Config</a></li>
        <li class="breadcrumb-item active">{{ $title }}</li>
    </ol>
    <div class="box box-block bg-white">
        <h5>{{ $title }}</h5>
        <p class="font-90 text-muted mb-1"> {{ $description }}</p>
        <span class="badge badge-pill bg-info">{{$group->description ?? '' }} - {{$type->description ?? '' }}</span>
        <hr />
        <form class="form-material material-primary" id="defaultform" method="POST"
            action="{{ route('setin.addnewcltyp') }}">@csrf
            <div class="form-group row">
                <label for="" class="col-sm-2 form-control-label">Days to accrue
                </label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="numericrequired" name="daystoaccrue"
                        placeholder="2.25" autocomplete="off">
                    <small id="numericrequiredcheck" style="color: red;">required</small>
                </div>
                <label for="" class="col-sm-2 form-control-label">Maximun Days
                </label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="maximundays" name="maximundays"
                        placeholder="25" autocomplete="off">
                    <small id="maximundayscheck" style="color: red;">required</small>
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-sm-2 form-control-label">On Max Days?</label>
                <div class="col-sm-4">
                    <select class="js-example-basic-single w-100" name="onmaxdays" id="currencycode" />
                    <option value="">pick option</option>
                    <option value="1">stop accruing</option>
                    <option value="1">proceed to accrue</option>
                    </select>
                    <small id="currencycodecheck" style="color: red;">required</small>
                </div>
            </div>
            <div class="form-group row">
                @if (in_array(1,$arraycontrolids))
                <div class="offset-sm-2 col-sm-10">
                    <button type="submit" class="btn btn-primary" id="btn-setup-typegroup-config">
                        submit</button>
                </div> @endif
            </div>
            @include('layout.arlet')
        </form>
    </div>
</div>
<!-- Content End-->

@endsection
@section('additional js')
<script src="{{ asset('js/validation/intake-setup.js') }}"></script>
<script src="{{ asset('css/select2/select2.min.js') }}"></script>
<script src="{{ asset('js/select2.js') }}"></script>
<!-- Additional JS End-->
@endsection