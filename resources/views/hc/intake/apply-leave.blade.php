@php
$title = 'Apply Leave';
$description = 'complete all required field to submit application...';
$uid= Crypt::encrypt($myuser->id);
$rid = Crypt::encrypt($myrole->id);
@endphp
@extends('layout.hc.hc-main-menu')
@section('title', 'Apply Leave')
@section('additional css')
<!-- Additional css Start-->
<link rel="stylesheet" href="{{ asset('css/select2/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/select2-bootstrap-theme/select2-bootstrap.min.css') }}">
<!-- Additional css End-->
<script src="{{ asset('js/dropdown-get-data.js') }}"></script>
@endsection
@section('content')
<!-- Content Start-->
<div class="container-fluid">
    <h4>{{ $title }}</h4>
    <ol class="breadcrumb no-bg mb-1">
        <li class="breadcrumb-item"><a href="{{route('dash.hc')}}">Dashboard</a></li>
        <li class="breadcrumb-item active">{{ $title }}</li>
    </ol>
    <div class="box box-block bg-white">
        <h5>{{ $title }}</h5>
        <p class="font-90 text-muted mb-1"> {{ $description }}</p>
        <form class="form-material material-primary" id="defaultform" method="POST"
            action="{{ route('hcin.cretlev',[$uid,$rid]) }}" enctype="multipart/form-data">@csrf
            <div class="form-group row">
                <label for="" class="col-sm-2 col-form-label">Name</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control " value="{{ $myuser->lastname }} {{ $myuser->firstname}}" readonly>
                    <input type="text" hidden value="{{ $myuser->id }}" readonly id="myuser">
                </div>
                <h5>Details:</h5>
                <div class="col-sm-4">
                    <div id="leavedetailsform">
                        <div class="clearfix mb-0-25">
                            <span class="float-xs-left">Leave Type:</span>
                            <span class="float-xs-right" id="leavetype"></span>
                        </div>
                        <div class="clearfix mb-0-25">
                            <span class="float-xs-left">Available:</span>
                            <input type="hidden" name="daysavailable" id="daysavailable_input">
                            <span class="float-xs-right" id="daysavailable"></span>
                        </div>
                    </div>
                    <div class="clearfix mb-0-25">
                        <span class="float-xs-left">Days Applied:</span>
                        <span class="float-xs-right" id="daysapplied"></span>
                        <input type="hidden" name="daysapplied" id="daysapplied_input">
                    </div>
                    <div class="b-a b-a-success b-a-width-1 mb-0-5"></div>
                    <small id="insufficientdayscheck" style="color: red;"></small>
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-sm-2 form-control-label">Leave Type</label>
                <div class="col-sm-4">
                    <select class="js-example-basic-single w-100" name="leavegroup" id="leavegroup" onchange="getavailableleavedays();">
                        <option value="">select type</option>
                        @foreach ($typegroup as $abc)
                        <option value="{{ $abc->typegroupid }}"> {{ $abc->description }}</option>
                        @endforeach
                    </select>
                    <small id="leavegroupcheck" style="color: red;">required</small>
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-sm-2 form-control-label">From</label>
                <div class="col-sm-4">
                    <input type="date" class="form-control" id="datefrom" name="datefrom">
                    <small id="datefromcheck" style="color: red;">required</small>
                </div>
                <label for="ClientType" class="col-sm-2 form-control-label">To</label>
                <div class="col-sm-4">
                    <input type="date" class="form-control" id="dateto" name="dateto">
                    <small id="datetocheck" style="color: red;">required</small>
                </div>
            </div>
            <div class="form-group row">
                <label for="pdf" class="col-sm-2 col-form-label">Attachment</label>
                <div class="col-sm-4">
                    <input type="file" class="form-control" id="notrequiredpdf" name="leaveattachment"
                        accept=".pdf">
                    <small id="notrequiredpdfcheck" style="color: red;">required</small>
                </div>
            </div>
            <div class="form-group row">
                <label for="Highlights" class="col-sm-2 col-form-label">Any Comments?</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="commentshighlights" name="commentshighlights">
                    <small id="commentshighlightscheck" style="color: red;"></small>
                </div>

            </div>
            <br />
            <div class="form-group row">@if (in_array(1,$arraycontrolids))
                <div class="offset-sm-2 col-sm-10">
                    <button type="submit" class="btn btn-primary" id="btn-apply-leave">submit</button>
                </div> @endif
            </div>
            @include('layout.arlet')
        </form>
    </div>
</div>
<!-- Content End-->

@endsection
@section('additional js')
<script src="{{ asset('js/validation/intake-hc.js') }}"></script>
<script src="{{ asset('css/select2/select2.min.js') }}"></script>
<script src="{{ asset('js/select2.js') }}"></script>
<!-- Additional JS End-->
@endsection