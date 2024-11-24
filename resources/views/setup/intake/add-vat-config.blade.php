@php 
$title = 'Add VAT';
$description = 'add property type to add vat when billing vat...'; @endphp
@extends('layout.setup-main-menu')
@section('title', 'Setup VAT')
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
                action="{{ route('setin.addnewvat') }}">@csrf
                <div class="form-group row">
                    <label for="" class="col-sm-2 form-control-label">Property Type</label>
                    <div class="col-sm-6">
                            <select id="leaselist" multiple="multiple" name="combinedleases[]" 
                            class="js-example-basic-single w-100">
                            @foreach ($proptype as $abc)
                                <option value="{{ $abc->id }}"> {{ $abc->description }} </option>
                            @endforeach
                            </select>
                            <small id="leaselistcheck" style="color: red;">required</small>
                    </div>
                </div><br/>
                <div class="form-group row">
                    <label for="" class="col-sm-2 form-control-label">Rate in %
                    </label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="numericrequired" name="percentagerate"
                            placeholder="0.38" autocomplete="off">
                    <small id="numericrequiredcheck" style="color: red;">required</small>
                    </div>
                </div>
                <div class="form-group row">
                @if (in_array(1,$arraycontrolids))
                <div class="offset-sm-2 col-sm-10">
                    <button type="submit" class="btn btn-primary" id="btn-submit-vat-config" >
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