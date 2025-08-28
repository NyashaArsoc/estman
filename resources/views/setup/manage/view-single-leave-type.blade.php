@php
$title = 'Leave Type';
$description = 'below are leave type details .';
$typeid= Crypt::encrypt($type->id);
$joinedtypeconfig = $config->implode('required', ',');
$joinedtypeconfig = preg_replace('/\s+/', '', $joinedtypeconfig);
$arraytypecofig = explode(',',$joinedtypeconfig);
@endphp
@extends('layout.no-menu-layout')
@section('title', 'View Leave Type')
@section('content')
<!-- Content Start-->
<div class="container-fluid">
    <h4>{{ $title }}</h4>
    <ol class="breadcrumb no-bg mb-1">
        <li class="breadcrumb-item"><a href="{{ route('dash.setup') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('setman.listlevtype') }}">List</a></li>
        <li class="breadcrumb-item active">{{ $title }}</li>
    </ol>
    <div class="box box-block bg-white">
        <h5>{{ $title }}</h5>
        <p class="font-90 text-muted mb-1">{{ $description }}</p>
        <span class="badge badge-pill bg-info">{{$type->description ?? '' }}</span>
        <hr />
        <!-- Tabs Navigation -->
        <ul class="nav nav-tabs" id="clientTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="work-days-tab" data-toggle="tab" href="#work-days" role="tab" aria-controls="work-days" aria-selected="true">Configs</a>
            </li>
        </ul>
        <!-- Tabs Content -->
        <div class="tab-content" id="clientTabContent">
            <div class="tab-pane show active" id="work-days" role="tabpanel" aria-labelledby="days-days-tab"><br />
                <form class="form-material material-primary" id="defaultform" method="POST"
                    action="{{ route('setman.assignconfigtype',$typeid) }}">@csrf
                    <h5 class="mt-2">Select Required Fields</h5>
                    <hr />
                    <div class="form-group row">
                        <div class="col-sm-8">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="required[]" value="Attach" @if(in_array('Attach',$arraytypecofig)) checked @endif>
                                <label class="form-check-label" for="attachment">Attachment</label>
                            </div>
                        </div>
                    </div>
                    @if (in_array(1,$arraycontrolids)) <button type="submit" class="btn btn-primary"
                        id="btn-sbt-work-days">submit</button> @endif
                </form>
            </div>
        </div><br />
        @include('layout.arlet')
    </div>
</div>
<!-- Content End-->

@endsection
@section('additional js')
<script src="{{ asset('js/validation/intake-setup.js') }}"></script>
<!-- Additional JS End-->
@endsection