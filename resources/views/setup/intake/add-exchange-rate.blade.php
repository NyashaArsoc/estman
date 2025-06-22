@php
$title = 'Add Exchange Rate';
$description = 'add currency exchange rate...'; @endphp
@extends('layout.setup-main-menu')
@section('title', 'Add Rate')
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
        <li class="breadcrumb-item active">{{ $title }}</li>
    </ol>
    <div class="box box-block bg-white">
        <h5>{{ $title }}</h5>
        <p class="font-90 text-muted mb-1"> {{ $description }}</p>
        <form class="form-material material-primary" id="defaultform" method="POST"
            action="{{ route('setin.newratecurr') }}">@csrf
            <div class="form-group row">
                <label for="Commission" class="col-sm-2 form-control-label">Currency
                </label>
                <div class="col-sm-4">
                    <select class="js-example-basic-single w-100" name="currencycode" id="currencycode" />
                    <option value="">select currency</option>
                    @foreach ($currency as $abc)
                    <option value="{{ trim($abc->code) }}"> {{ $abc->code}}
                    </option>
                    @endforeach
                    </select>
                    <small id="currencycodecheck" style="color: red;">required</small>
                </div>
            </div><br />
            <div class="form-group row">
                <label for="" class="col-sm-2 form-control-label">Buying Rate</label>
                <div class="col-sm-2">
                    <input type="text" class="form-control" id="buyingrate" name="buyingrate"
                        placeholder="8.987" autocomplete="off">
                    <small id="buyingratecheck" style="color: red;">required</small>
                </div>
                <label for="" class="col-sm-2 form-control-label">Selling Rate</label>
                <div class="col-sm-2">
                    <input type="text" class="form-control" id="sellingrate" name="sellingrate"
                        placeholder="6.89" autocomplete="off">
                    <small id="sellingratecheck" style="color: red;">required</small>
                </div>
                <label for="" class="col-sm-2 form-control-label">Mean Rate</label>
                <div class="col-sm-2">
                    <small id="meanratecheck" style="color: red;"></small>
                </div>
            </div>
            <div class="form-group row">
                @if (in_array(1,$arraycontrolids))
                <div class="offset-sm-2 col-sm-10">
                    <button type="submit" class="btn btn-primary" id="btn-submit-exchange-rate">
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
<script src="{{ asset('css/select2/select2.min.js') }}"></script>
<script src="{{ asset('js/select2.js') }}"></script>
<script src="{{ asset('js/validation/intake-setup.js') }}"></script>
<!-- Additional JS End-->
@endsection