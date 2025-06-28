@php
$title = 'Leave Takeon Balances';
$id= Crypt::encrypt($staff->id);
$tid= Crypt::encrypt($typegroup->id);
$description = 'add leave take-on days...'; @endphp
@extends('layout.no-menu-layout')
@section('title', 'Add Days')

@section('content')
<!-- Content Start-->
<div class="container-fluid">
    <h4>{{ $title }}</h4>
    <ol class="breadcrumb no-bg mb-1">
        <li class="breadcrumb-item"><a href="{{route('dash.setup')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('hcin.lstgrpusr',$id) }}">List</a></li>
        <li class="breadcrumb-item active">{{ $title }}</li>
    </ol>
    <div class="box box-block bg-white">
        <h5>{{ $title }}</h5>
        <p class="font-90 text-muted mb-1"> {{ $description }}</p>
        <span class="badge badge-pill bg-primary">{{ $staff->lastname }} {{ $staff->firstname}} :
            {{ $staffgroup->description}}
        </span>
        <hr />
        <form class="form-material material-primary" id="defaultform" method="POST"
            action="{{ route('hcin.takeon',[$id,$tid]) }}">@csrf
            <div class="form-group row">
                <label for="" class="col-sm-2 form-control-label">Leave Type
                </label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" readonly value="{{$typegroup->description}}">
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-sm-2 form-control-label">Days
                </label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="numericrequired" name="takeondays"
                        placeholder="3.38" autocomplete="off">
                    <small id="numericrequiredcheck" style="color: red;">required</small>
                </div>
            </div>
            <div class="form-group row">
                @if (in_array(1,$arraycontrolids))
                <div class="offset-sm-2 col-sm-10">
                    <button type="submit" class="btn btn-primary" id="btn-submit-takeon-days">
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
<script src="{{ asset('js/validation/intake-hc.js') }}"></script>
<!-- Additional JS End-->
@endsection