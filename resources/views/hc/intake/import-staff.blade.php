@php
$title = 'Import Staff';
$description = 'import new employees to leave management...'; @endphp
@extends('layout.hc.hc-main-menu')
@section('title', 'Import Staff')
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
        <li class="breadcrumb-item"><a href="{{route('dash.hc')}}">Dashboard</a></li>
        <li class="breadcrumb-item active">{{ $title }}</li>
    </ol>
    <div class="box box-block bg-white">
        <h5>{{ $title }}</h5>
        <p class="font-90 text-muted mb-1"> {{ $description }}</p>
        <form class="form-material material-primary" id="" method="POST"
            action="{{ route('hcin.crtstaf') }}">@csrf
            <div class="form-group row">
                <label for="" class="col-sm-2 form-control-label">Staff</label>
                <div class="col-sm-4">
                    <select class="js-example-basic-single w-100" name="staff" id="stafflist" />
                    <option value="">select staff</option>
                    @foreach ($staff as $abc)
                    <option value="{{ $abc->id }}"> {{ $abc->lastname }} {{ $abc->firstname}}</option>
                    @endforeach
                    </select>
                    <small id="stafflistcheck" style="color: red;">required</small>
                </div>
                <label for="" class="col-sm-2 form-control-label">Leave Group</label>
                <div class="col-sm-4">
                    <select class="js-example-basic-single w-100" name="leavegroup" id="leavegroup" />
                    <option value="">select group</option>
                    @foreach ($group as $abc)
                    <option value="{{ $abc->id }}"> {{ $abc->description }}</option>
                    @endforeach
                    </select>
                    <small id="leavegroupcheck" style="color: red;">required</small>
                </div>
            </div><br />
            <div class="form-group row">@if (in_array(1,$arraycontrolids))
                <div class="offset-sm-2 col-sm-10">
                    <button type="submit" class="btn btn-primary" id="btn-import-staff">submit</button>
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