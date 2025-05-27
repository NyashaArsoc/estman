@php
$title = 'Portfolio Instruction';
$description = 'create new portfolio instruction...';
@endphp
@extends('layout.valuation-main-menu')
@section('title', 'Portfolio Instruction')
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
        <li class="breadcrumb-item"><a href="{{route('dash.val')}}">Dashboard</a></li>
        <li class="breadcrumb-item active">{{ $title }}</li>
    </ol>
    <div class="box box-block bg-white">
        <h5>{{ $title }}</h5>
        <p class="font-90 text-muted mb-1"> {{ $description }}</p>
        <form class="form-material material-primary" id="defaultform" method="POST"
            action="{{ route('valin.portpage1') }}"> @csrf
            <div class="form-group row">
                <label for="" class="col-sm-2 form-control-label">Portfolio</label>
                <div class="col-sm-4">
                    <select class="js-example-basic-single w-100" name="portfolioname"
                        id="portfolioname" />
                    <option value="">select portfolio</option>
                    @foreach ($port as $abc)
                    <option value="{{ $abc->id }}"> {{ $abc->fullname ?? ''}} {{ $abc->companyname ?? ''}} - {{ $abc->contactperson ?? '' }}
                    </option>
                    @endforeach
                    </select>
                    <small id="portfolionamecheck" style="color: red;">required</small>
                </div>
                <label for="" class="col-sm-2 col-form-label">Valuer Name </label>
                <div class="col-sm-4">
                    <select class="js-example-basic-single w-100" name="valuername" id="valuername" />
                    <option value="">select valuer name </option>
                    @foreach ($valuer as $abc)
                    <option value="{{ $abc->userid }}"> {{ $abc->fullname }}
                    </option>
                    @endforeach
                    </select>
                    <small id="valuernamecheck" style="color: red;">required</small>
                </div>
            </div><br />
            <div class="form-group row">
                <div class="offset-sm-2 col-sm-10">
                    <button type="submit" class="btn btn-primary" id="btn-val-instr-portfolio-1">
                        <i class="ti-arrow-right mr-0-5"></i> next</button>
                </div>
            </div>
            @include('layout.arlet')
        </form>
    </div>
</div>
<!-- Content End-->
@endsection
@section('additional js')
<!-- Additional JS Start-->
<script src="{{ asset('js/validation/intakevaluation.js') }}"></script>
<script src="{{ asset('css/select2/select2.min.js') }}"></script>
<script src="{{ asset('js/select2.js') }}"></script>
<!-- Additional JS End-->
@endsection