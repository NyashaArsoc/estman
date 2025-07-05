@php
$title = 'Leave Application';
$description = 'leave application approval...';
$id= Crypt::encrypt($application->id);
@endphp
@extends('layout.no-menu-layout')
@section('title', 'Application')
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
        <li class="breadcrumb-item"><a href="{{ route('hcapp.listlev') }}">List</a></li>
        <li class="breadcrumb-item active">{{ $title }}</li>
    </ol>
    <div class="box box-block bg-white">
        <h5>{{ $title }}</h5>
        <p class="font-90 text-muted mb-1"> {{ $description }}</p>
        <form class="form-material material-primary" id="defaultform" method="POST"
            action="" enctype="multipart/form-data">@csrf
            <div class="form-group row">
                <label for="" class="col-sm-2 col-form-label">Name</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control " value="{{ $staff->lastname }} {{ $staff->firstname}}" readonly>
                    <input type="text" hidden value="{{ $staff->id }}" readonly id="myuser">
                    <input type="text" hidden value="{{ $application->groupid }}" readonly id="myusergroup">
                </div>
                <h5>Details:</h5>
                <div class="col-sm-4">
                    <div id="leavedetailsform">
                        <div class="clearfix mb-0-25">
                            <span class="float-xs-left">Leave Type:</span>
                            <span class="float-xs-right" id="leavetype">{{ $staff->lastname }} </span>
                        </div>
                        <div class="clearfix mb-0-25">
                            <span class="float-xs-left">Dates:</span>
                            <span class="float-xs-right" id="daysapplied">{{ $application->datefrom }}
                                <small> <strong>til</strong></small> {{ $application->dateto }}

                        </div>
                        <div class="clearfix mb-0-25">
                            <span class="float-xs-right" id="daysapplied"> </span>
                        </div>
                        <div class="clearfix mb-0-25">
                            <span class="float-xs-left">Available:</span>
                            <input type="hidden" name="daysavailable" id="daysavailable_input">
                            <span class="float-xs-right" id="daysavailable">{{ $days->days }} </span>
                        </div>
                    </div>
                    <div class="clearfix mb-0-25">
                        <span class="float-xs-left">Days Applied:</span>
                        <span class="float-xs-right" id="daysapplied">{{ $application->daysapplied }} </span>
                    </div>
                    <div class="clearfix mb-0-25">
                        <span class="float-xs-left">Attachment:</span>
                        <span class="float-xs-right" id="daysapplied">{{ $application->attachments }} </span>
                    </div>
                    <div class="clearfix mb-0-25">
                        <span class="float-xs-left">Comments:</span>
                        <span class="float-xs-right" id="daysapplied">{{ $application->comments }} </span>
                    </div>
                    <div class="b-a b-a-success b-a-width-1 mb-0-5"></div>
                    <small id="insufficientdayscheck" style="color: red;"></small>
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
            <div class="form-group row">
                <div class="offset-sm-2 col-sm-4">
                    @if (in_array(5,$arraycontrolids))
                    <a class="btn btn-success btn-sm" href="{{route('hcapp.apprvleve',$id)}}" title="accept" onclick="confirminstruction(this); return false;">
                        <i class="ti-check mr-0-5"></i>approve</a>@endif
                    @if (in_array(6,$arraycontrolids))
                    <button type="submit" class="btn btn-danger btn-sm" id="btn-reject-entry"><i class="ti-close mr-0-5">
                        </i>decline</button>@endif
                </div>
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